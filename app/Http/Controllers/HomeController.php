<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stock;
use App\Models\Crypto;
use App\Models\Setting;
use App\Models\Trading;
use App\Models\Watchlist;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EmailOTPNotification;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $savings = $user->wallet->save;
        $investment = $user->wallet->invest;
        $trading = $user->wallet->trade;
        $locked = $user->wallet->locked;
        $wallet = $user->wallet->balance;

        $availableCash = ($wallet + ($savings + $investment + $trading));

        $transactions = $user->transaction()->orderBy('created_at', 'desc')->paginate(10); 

        $totalAmount = 0;

        // Group transactions by type (save, invest, trade) and by date
        $transact = $user->transaction()
        ->select(
            DB::raw('DATE(created_at) as date'),
            'type',
            DB::raw('SUM(amount) as total_amount')
        )
        ->groupBy('type', DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'asc')
        ->get();

        // Prepare data for the chart
        $alignedSavings = $transact->where('type', 'save')->pluck('total_amount');
        $alignedInvestments = $transact->where('type', 'invest')->pluck('total_amount');
        $alignedTrading = $transact->where('type', 'trade')->pluck('total_amount');
        $dates = $transact->pluck('date')->unique()->values(); // Get unique dates

        // Percentage data for the chart
        $totalAmount = $transact->sum('total_amount');

        $savingsTotal = $transact->where('type', 'save')->sum('total_amount');
        $investmentTotal = $transact->where('type', 'invest')->sum('total_amount');
        $tradingTotal = $transact->where('type', 'trade')->sum('total_amount');

        $savingsPercentage = $totalAmount > 0 ? ($savingsTotal / $totalAmount) * 100 : 0;
        $investmentPercentage = $totalAmount > 0 ? ($investmentTotal / $totalAmount) * 100 : 0;
        $tradingPercentage = $totalAmount > 0 ? ($tradingTotal / $totalAmount) * 100 : 0;


        // INVESTMENT PERCENTAGE CHANGE ::: START
        $total_amount = $user->investments()->sum('amount');
        $totalCredits = Investment::where('user_id', $user->id)
            ->with(['investmentTransaction' => function ($query) {
                $query->where('type', 'credit'); 
            }])
            ->get()
            ->pluck('investmentTransaction')
            ->flatten()
            ->sum('amount');


        if($total_amount > 1)
            $percentProfit = ($totalCredits / $total_amount * 100);
        else
            $percentProfit = 0;
        // INVESTMENT PERCENTAGE CHANGE ::: END


        // TRADES PERCENTAGE CHANGE ::: START
        $totalStocks = $user->trades('stocks')->sum('amount');

        $totalInvestment = 0;
        $totalCurrentValue = 0;
        $totalQuantity = 0;

        $stocks = $user->trades('stocks')->with('stock')->get();

        foreach ($stocks as $stock) {
            $investmentAmount = $stock->purchase_amount * $stock->quantity;
            $currentValue = $stock->stock['price'] * $stock->quantity;

            $currentQuantity = $stock->quantity;

            $totalInvestment += $investmentAmount;
            $totalCurrentValue += $currentValue;
            $totalQuantity += $currentQuantity;
        }

        $totalProfit = $totalCurrentValue - $totalInvestment;
        $percentageDifference = ($totalInvestment > 0) 
            ? ($totalProfit / $totalInvestment) * 100 
            : 0;
        
        $equityBalance = $totalCurrentValue;
        $totalAssetQuantity = $totalQuantity;

        if($totalStocks > 1)
            $equityBalancePercent = ($totalProfit / $totalStocks * 100);
        else 
            $equityBalancePercent = 0;
        // TRADES PERCENTAGE CHANGE ::: END


        // CRYPTO PERCENTAGE CHANGE ::: START
        $totalCrypto = $user->trades('crypto')->sum('amount');

        $totalInvestmentCrypto = 0;
        $totalCurrentValueCrypto = 0;
        $totalQuantityCrypto = 0;

        $stocks = $user->trades('crypto')->with('crypto')->get();

        foreach ($stocks as $stock) {
            $investmentAmountCrypto = $stock->purchase_amount * $stock->quantity;
            $currentValueCrypto = $stock->stock['price'] * $stock->quantity;

            $currentQuantityCrypto = $stock->quantity;

            $totalInvestmentCrypto += $investmentAmountCrypto;
            $totalCurrentValueCrypto += $currentValueCrypto;
            $totalQuantityCrypto += $currentQuantityCrypto;
        }

        $totalProfitCrypto = $totalCurrentValueCrypto - $totalInvestmentCrypto;
        $percentageDifferenceCrypto = ($totalInvestmentCrypto > 0) 
            ? ($totalProfitCrypto / $totalInvestmentCrypto) * 100 
            : 0;
        
        $equityBalanceCrypto = $totalCurrentValueCrypto;
        $totalAssetQuantityCrypto = $totalQuantityCrypto;

        if($totalCrypto > 1)
            $equityBalancePercentCrypto = ($totalProfitCrypto / $totalCrypto * 100);
        else 
            $equityBalancePercentCrypto = 0;
        // CRYPTO PERCENTAGE CHANGE ::: END


        $inv = $user->investments()->where('status', 'active')->sum('amount');

        $sav = $user->savings()
            ->with(['savingsTransactions' => function($query) {
                $query->where('type', 'debit')->where('status', 'success');
            }])
            ->get()
            ->pluck('savingsTransactions')
            ->flatten()
            ->sum('amount') ?? 0;

        $trd = $user->trades('stocks')->sum('amount') + $user->trades('crypto')->sum('amount');

        $lockedFunds = ($inv + $sav + $trd);    

        $slidesData = $this->getTopAssets();

        return view('user_.dashboard.index', [
            'title' => 'Dashboard', 
            'savings' => $savings,
            'trading' => $trading,
            'investment' => $investment,
            'locked' => $locked,
            'assets' => $totalAmount,
            'transactions' => $transactions,

            'dates' => $dates,
            'alignedSavings' => $alignedSavings->values(),
            'alignedInvestments' => $alignedInvestments->values(),
            'alignedTrading' => $alignedTrading->values(),

            'savingsPercentage' => $savingsPercentage,
            'investmentPercentage' => $percentProfit,
            'tradingPercentage' => $equityBalancePercent + $equityBalancePercentCrypto,

            'lockedFunds' => $lockedFunds,
            'slidesData' => $slidesData,

            'portfolio' => $availableCash,
        ]);
    }

    private function getTopAssets()
    {
        // Fetch top 5 Cryptos
        $cryptos = Crypto::orderBy('market_cap', 'desc')
            ->take(5)
            ->get();

        // Fetch top 5 Stocks
        $stocks = Stock::orderBy('market_cap', 'desc')
            ->take(5)
            ->get();

        // Merge the cryptos and stocks into one collection
        $assets = $cryptos->merge($stocks);

        // Define the color classes
        $colors = ['success', 'primary', 'secondary', 'info', 'warning', 'danger', 'dark'];

        // Iterate over assets and assign random colors and img
        $assets = $assets->map(function ($asset) use ($colors) {
            // Shuffle the color array to get a random color each time
            $shuffledColors = $colors;
            shuffle($shuffledColors); // Shuffle the array

            return [
                'name' => $asset->name,
                'icon' => $asset->img,  // Use asset's img as the icon
                'colorClass' => $shuffledColors[0], // Randomly assigned color
                'price' => "$" . number_format($asset->price, 2), // Formatting price
                'percentageChange' => number_format($asset->changes_percentage, 2) . "%",
                'changeDirection' => "ti-arrow-bear-right", // You can replace with actual direction logic
                'changeAmount' => "$" . number_format($asset->change, 2),
            ];
        });

        // Shuffle the assets array to mix stocks and cryptos randomly
        return $assets->shuffle(); // Return the shuffled assets directly as an array
    }

    public function kyc()
    {
        $user = auth()->user();

        return view('auth.kyc', [
            'user' => $user
        ]);
    }

    public function user_kyc()
    {
        $user = auth()->user();

        return view('user_.kyc.index', [
            'user' => $user
        ]);
    }

    public function profile()
    {
        try {
            $banks = json_decode(Http::get('https://api.paystack.co/bank')->getBody(), true)['data'];
        }catch (\Exception $exception){
            $banks = [];
        }

        $user = auth()->user();
        $balance = $user->wallet->balance;

        $savings = $user->wallet->save;
        $trading = $user->wallet->trade;
        $investment = $user->wallet->invest;
        
        return view('user_.profile.index', [
            'banks' => $banks, 
            'title' => 'Profile',
            'user' => $user,
            'balance' => $balance,
            'savings' => $savings,
            'trading' => $trading,
            'investment' => $investment,
        ]);
    }

    public function settings()
    {
        $user = auth()->user();
        
        return view('user_.profile.settings', [
            'title' => 'Profile',
            'user' => $user,
        ]);
    }

    public function showMarket($product)
    {
        return view('user.market.data', compact('product'));
    }

    public function market()
    {
        return view('user.market.index');
    }

    public function download(Request $request)
    {
        if ($request['path']){
            return Response::download($request['path']);
        }
        return back()->with('error', 'Error downloading file');
    }

    public function updateProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'phone' => ['required', 'size:10'],
            'phone_code' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'bank_name' => ['required'],
            'account_number' => ['required'],
            'account_name' => ['required'],
            'nk_name' => ['required'],
            'nk_phone' => ['required'],
            'nk_address' => ['required'],
            'avatar' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:2048'],
            'id' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:2048']
        ],[
            'nk_name.required' => 'The next of kin name is required',
            'nk_phone.required' => 'The next of kin phone is required',
            'nk_address.required' => 'The next of kin address is required'
        ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data');
        }
        //        Collect data from request
        $data = $request->only([
            'name', 'phone', 'phone_code', 'state', 'country', 'city',
            'address', 'bank_name', 'account_name', 'account_number',
            'nk_name', 'nk_phone', 'nk_address']);
        //        Check if user uploaded file and save
        if ($request->file('avatar')){
            if ($oldAvatar = auth()->user()['avatar'])
                try {unlink($oldAvatar);}
                catch(\Exception $e){}
            $destinationPath = 'assets/photos'; // upload path
            static::createDirectoryIfNotExists($destinationPath);
            $transferImage = \auth()->user()['id'].'-'. time() . '.' . $request['avatar']->getClientOriginalExtension();
            $image = Image::make($request->file('avatar'));
            $image->save($destinationPath . '/' . $transferImage, 40);
            $data['avatar'] = $destinationPath ."/".$transferImage;
        }
        if ($request->file('id')){
            if ($oldID = auth()->user()['identification'])
                try {unlink($oldID);}
                catch(\Exception $e){}
            $destinationPath = 'assets/ids'; // upload path
            static::createDirectoryIfNotExists($destinationPath);
            $transferImage = \auth()->user()['id'].'-'. time() . '.' . $request['id']->getClientOriginalExtension();
            $image = Image::make($request->file('id'));
            $image->save($destinationPath . '/' . $transferImage, 40);
            $data['identification'] = $destinationPath ."/".$transferImage;
        }
        //        Update profile
        if (auth()->user()->update($data)){
            if (auth()->user()['gotMail'] == 0) {
                NotificationController::sendWelcomeEmailNotification(auth()->user());
                auth()->user()->update(['gotMail' => 1]);
            }

            //Generate wallet
            // $walletController = new WalletController();
            // $walletController->generateVirtualAccount();

            return back()->with('success', 'Profile updated successfully');
        }
        return back()->withInput()->with('error', 'Error updating profile');
    }

    public function changePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'same:confirm_password'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->with('error', 'Invalid input data');
        }
        //        Check if user didn't auth with socials
        if (auth()->user()->authenticatedWithSocials()){
            return back()->with('error', 'Action not allowed');
        }
        //      Check if old password matches
        if (!Hash::check($request['old_password'], auth()->user()['password'])){
            return back()->with('error', 'Old password incorrect');
        }
        //      Change password
        if (auth()->user()->update(['password' => Hash::make($request['new_password'])])){
            return back()->with('success', 'Password changed successfully');
        }
        return back()->with('error', 'Error changing password');
    }

    public function verificationSuccess()
    {
        return view('auth.verified');
    }

    protected function getDashboardData(): array
    {
        $transactionsMonth = [];
        $transactionsYear = [];
        $investmentsMonth = [];
        $investmentsYear = [];
        $tradesBuyMonth = [];
        $tradesSellMonth = [];
        $tradesBuyYear = [];
        $tradesSellYear = [];
        //        Generate current month data
        for ($day = 1; $day <= date('t'); $day++){
            $transactionsMonth[] = round(auth()->user()->transactions()
                ->where('status', 'approved')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $investmentsMonth[] = round(auth()->user()->investments()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesBuyMonth[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'buy')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesSellMonth[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'sell')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
        }
        //        Generate current year data
        for ($month = 1; $month <= 12; $month++){
            $transactionsYear[] = round(auth()->user()->transactions()
                ->where('status', 'approved')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $investmentsYear[] = round(auth()->user()->investments()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $tradesBuyYear[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'buy')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $tradesSellYear[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'sell')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
        }
        //       compute paid investment data
        $paidInvestment = auth()->user()->investments()
            ->where('status', 'settled')
            ->sum('amount');
        //       compute total investment data
        $totalInvestment = auth()->user()->investments()
            ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
            ->sum('amount');
        return [
            'transactions' => ['month' => $transactionsMonth, 'year' => $transactionsYear],
            'tradesBuy' => ['month' => $tradesBuyMonth, 'year' => $tradesBuyYear],
            'tradesSell' => ['month' => $tradesSellMonth, 'year' => $tradesSellYear],
            'investments' => ['month' => $investmentsMonth, 'year' => $investmentsYear],
            'paidInvestment' => $paidInvestment,
            'totalInvestment' => $totalInvestment
        ];
    }

    private function _stateCountryIDForCountryName($country_name)
    {
        return DB::table('countries')->where("name", "$country_name")->first()->id;
    }
    
    public function getState($country_name)
    {
        $country_name = urldecode($country_name);
        $country_id = self::_stateCountryIDForCountryName($country_name);
        $states = DB::table("states")
            ->where("country_id", $country_id)
            ->get('name', 'id');

        return json_encode($states);
    }

    public static function formatHumanFriendlyNumber($num)
    {
        $num = (int) $num;
        if($num>1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }

    public static function createDirectoryIfNotExists($path)
    {
        if (!file_exists($path)) {
            File::makeDirectory($path);
        }
    }

    public function updateUserInfo(Request $request)
    {
        // Validate all inputs
        $validator = Validator::make($request->all(), [
            // Payment Information
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|numeric',
            'account_name' => 'nullable|string|max:255',
            'account_info' => 'nullable|string',
            'wallet_asset' => 'nullable|string',
            'wallet_network' => 'nullable|string',
            'wallet_address' => 'nullable|string',
            
            // Personal Information
            'location' => 'required|string',
            'country' => 'required|string',
            'state' => 'nullable|string',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            
            // Next of Kin Information
            'nk_name' => 'required|string|max:255',
            'nk_phone' => 'required|string', // Adjust validation according to phone format
            'nk_relationship' => 'required|string',
            'nk_country' => 'required|string',
            'nk_state' => 'nullable|string',
            'nk_address' => 'required|string',
            'nk_postal' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();

        // Update user information
        $user->update([
            // Payment Information
            'bank_name' => $request->input('bank_name'),
            'account_number' => $request->input('account_number'),
            'account_name' => $request->input('account_name'),
            'account_info' => $request->input('account_info'),
            'wallet_asset' => $request->input('wallet_asset'),
            'wallet_network' => $request->input('wallet_network'),
            'wallet_address' => $request->input('wallet_address'),
            
            // Personal Information
            'location' => $request->input('location'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'postal_code' => $request->input('postal_code'),
            'address' => $request->input('address'),
            
            // Next of Kin Information
            'nk_name' => $request->input('nk_name'),
            'nk_phone' => $request->input('nk_phone'),
            'nk_relation' => $request->input('nk_relationship'),
            'nk_country' => $request->input('nk_country'),
            'nk_state' => $request->input('nk_state'),
            'nk_address' => $request->input('nk_address'),
            'nk_postal' => $request->input('nk_postal'),
        ]);

        return redirect()->route('dashboard')->with('status', 'Your information has been updated successfully!');
    }

    public function tabUpdates(Request $request)
    {
        if ($request->screen == 'one')
        {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'avatar' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:2048'],
            ]);

            if ($validator->fails()) {
                // Retrieve all error messages
                $errors = $validator->errors()->all();
            
                // Convert errors to a readable string
                $errorMessage = implode(', ', $errors);
            
                return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data: ' . $errorMessage);
            }

            $data = $request->only(['first_name', 'last_name', 'email', 'phone']);

            if ($request->avatar){
                if ($oldAvatar = auth()->user()['avatar'])
                    try {unlink($oldAvatar);}
                    catch(\Exception $e){}
                $destinationPath = 'assets/photos'; // upload path
                static::createDirectoryIfNotExists($destinationPath);
                $transferImage = \auth()->user()['id'].'-'. time() . '.' . $request['avatar']->getClientOriginalExtension();
                $image = Image::make($request->file('avatar'));
                $image->save($destinationPath . '/' . $transferImage, 40);
                $data['avatar'] = $destinationPath ."/".$transferImage;
            }

            //        Update profile
            if (auth()->user()->update($data)){
                return back()->with('success', 'Profile updated successfully');
            }
            return back()->withInput()->with('error', 'Error updating profile');

        }

        if ($request->screen == 'three')
        {
            $validator = Validator::make($request->all(), [
                'account_name' => ['sometimes'],
                'account_number' => ['sometimes'],
                'bank_name' => ['sometimes'],
                'swiss_code' => ['sometimes'],
                'reference' => ['sometimes'],
                'others' => ['sometimes'],
            ]);

            if ($validator->fails()) {
                // Retrieve all error messages
                $errors = $validator->errors()->all();
            
                // Convert errors to a readable string
                $errorMessage = implode(', ', $errors);
            
                return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data: ' . $errorMessage);
            }

            $user =auth()->user();

            $update = $user->update([
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'swiss_code' => $request->swiss_code,
                'reference' => $request->reference,
                'account_info' => $request->others,
            ]);

            // Update profile
            if ($update) {
                return back()->with('success', 'Profile updated successfully');
            }
            return back()->withInput()->with('error', 'Error updating profile');

        }

        if ($request->screen == 'four')
        {
            $validator = Validator::make($request->all(), [
                'coin' => ['sometimes'],
                'network' => ['sometimes'],
                'wallet_address' => ['sometimes'],
            ]);

            if ($validator->fails()) {
                // Retrieve all error messages
                $errors = $validator->errors()->all();
            
                // Convert errors to a readable string
                $errorMessage = implode(', ', $errors);
            
                return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data: ' . $errorMessage);
            }

            $user =auth()->user();

            $update = $user->update([
                'wallet_asset' => $request->coin,
                'wallet_network' => $request->network,
                'wallet_address' => $request->wallet_address,
            ]);

            // Update profile
            if ($update) {
                return back()->with('success', 'Profile updated successfully');
            }
            return back()->withInput()->with('error', 'Error updating profile');

        }

        if ($request->screen == 'five')
        {
            $validator = Validator::make($request->all(), [
                'ssn' => ['sometimes'],
                'dob' => ['sometimes'],
                'location' => ['sometimes'],
                'country' => ['sometimes'],
                'state' => ['sometimes'],
                'postal_code' => ['sometimes'],
                'address' => ['sometimes'],
                'nk_name' => ['sometimes'],
                'nk_phone' => ['sometimes'],
                'nk_relationship' => ['sometimes'],
                'nk_country' => ['sometimes'],
                'nk_state' => ['sometimes'],
                'nk_address' => ['sometimes'],
                'nk_postal' => ['sometimes'],
            ]);

            if ($validator->fails()) {
                // Retrieve all error messages
                $errors = $validator->errors()->all();
            
                // Convert errors to a readable string
                $errorMessage = implode(', ', $errors);
            
                return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data: ' . $errorMessage);
            }

            $user =auth()->user();

            $update = $user->update([
                'ssn' => $request->ssn,
                'dob' => $request->dob,
                'location' => $request->location,
                'country' => $request->country,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'nk_name' => $request->nk_name,
                'nk_phone' => $request->nk_phone,
                'nk_relation' => $request->nk_relationship,
                'nk_country' => $request->nk_country,
                'nk_state' => $request->nk_state,
                'nk_address' => $request->nk_address,
                'nk_postal' => $request->nk_postal,
            ]);

            // Update profile
            if ($update) {
                return back()->with('success', 'Profile updated successfully');
            }
            return back()->withInput()->with('error', 'Error updating profile');

        }

        if ($request->screen == 'six')
        {
            dd($request->all());
            $validator = Validator::make($request->all(), [
                'nk_name' => ['sometimes'],
                'nk_phone' => ['sometimes'],
                'nk_relationship' => ['sometimes'],
                'nk_country' => ['sometimes'],
                'nk_state' => ['sometimes'],
                'nk_address' => ['sometimes'],
                'nk_postal' => ['sometimes'],
            ]);

            if ($validator->fails()) {
                // Retrieve all error messages
                $errors = $validator->errors()->all();
            
                // Convert errors to a readable string
                $errorMessage = implode(', ', $errors);
            
                return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data: ' . $errorMessage);
            }

            $user =auth()->user();

            $update = $user->update([
                'nk_name' => $request->nk_name,
                'nk_phone' => $request->nk_phone,
                'nk_relation' => $request->nk_relationship,
                'nk_country' => $request->nk_country,
                'nk_state' => $request->nk_state,
                'nk_address' => $request->nk_address,
                'nk_postal' => $request->nk_postal,
            ]);

            // Update profile
            if ($update) {
                return back()->with('success', 'Profile updated successfully');
            }
            return back()->withInput()->with('error', 'Error updating profile');

        }

        if ($request->screen == 'seven') {
            $validator = Validator::make($request->all(), [
                'id_type' => 'required',
                'id_number' => 'required',
                'front_id' => 'required',
                'back_id' => 'required',
            ]);

            if ($validator->fails()){
                return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data');
            }

            $user = auth()->user();
            $data = [
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'front_id' => null,
                'back_id' => null,
                'is_id_approved' => 'pending'
            ];
    
            // Handle front ID image upload
            if ($request->hasFile('front_id')) {
                // Delete the old front ID image if it exists
                if ($oldFrontId = $user->front_id) {
                    try {
                        unlink(public_path($oldFrontId)); // Delete old image
                    } catch (\Exception $e) {
                        // Handle any error
                    }
                }
    
                // Define the upload path for front ID
                $destinationPath = 'assets/identification'; // upload path
                static::createDirectoryIfNotExists($destinationPath);
    
                // Generate a unique file name
                $frontImage = $user->id . '-front-' . time() . '.' . $request->file('front_id')->getClientOriginalExtension();
    
                // Save the front ID image
                $image = Image::make($request->file('front_id'));
                $image->save(public_path($destinationPath . '/' . $frontImage), 40); // 40% quality
    
                // Set the path of the saved front ID image
                $data['front_id'] = $destinationPath . '/' . $frontImage;
            }
    
            // Handle back ID image upload
            if ($request->hasFile('back_id')) {
                // Delete the old back ID image if it exists
                if ($oldBackId = $user->back_id) {
                    try {
                        unlink(public_path($oldBackId)); // Delete old image
                    } catch (\Exception $e) {
                        // Handle any error
                    }
                }
    
                // Define the upload path for back ID
                $destinationPath = 'assets/identification'; // upload path
                static::createDirectoryIfNotExists($destinationPath);
    
                // Generate a unique file name
                $backImage = $user->id . '-back-' . time() . '.' . $request->file('back_id')->getClientOriginalExtension();
    
                // Save the back ID image
                $image = Image::make($request->file('back_id'));
                $image->save(public_path($destinationPath . '/' . $backImage), 40); // 40% quality
    
                // Set the path of the saved back ID image
                $data['back_id'] = $destinationPath . '/' . $backImage;
            }
    
            // Update the user's identification details in the database
            $update = $user->update($data);
    
            // Check if the update was successful
            if ($update) {
                return back()->with('success', 'Identity updated successfully');
            }
    
            return back()->withInput()->with('error', 'Error updating profile');
        }
    

        if ($request->screen == 'eight')
        {
            // $validator = Validator::make($request->all(), [
            //     'nk_name' => ['sometimes'],
            //     'nk_phone' => ['sometimes'],
            //     'nk_relationship' => ['sometimes'],
            //     'nk_country' => ['sometimes'],
            //     'nk_state' => ['sometimes'],
            //     'nk_address' => ['sometimes'],
            //     'nk_postal' => ['sometimes'],
            // ]);

            // if ($validator->fails()) {
            //     // Retrieve all error messages
            //     $errors = $validator->errors()->all();
            
            //     // Convert errors to a readable string
            //     $errorMessage = implode(', ', $errors);
            
            //     return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data: ' . $errorMessage);
            // }

            // $user =auth()->user();

            // $update = $user->update([
            //     'nk_name' => $request->nk_name,
            //     'nk_phone' => $request->nk_phone,
            //     'nk_relation' => $request->nk_relationship,
            //     'nk_country' => $request->nk_country,
            //     'nk_state' => $request->nk_state,
            //     'nk_address' => $request->nk_address,
            //     'nk_postal' => $request->nk_postal,
            // ]);

            // Update profile
            // if ($update) {
                return back()->with('success', 'Profile updated successfully');
            // }
            // return back()->withInput()->with('error', 'Error updating profile');

        }

        if ($request->screen == 'proof') {
            // Validate file
            $request->validate([
                'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3072', // Validate file type and size
            ]);
    
            $user = auth()->user();
            $data = null;
    
            if ($request->hasFile('proof')) {
                // If there's an existing proof file, delete it
                if ($oldProof = $user->proof) {
                    try {
                        unlink(public_path($oldProof)); // Delete old file
                    } catch (\Exception $e) {
                        // Handle file deletion error
                    }
                }
    
                // Handle the new file upload
                $file = $request->file('proof');
                $destinationPath = 'assets/proof'; // Define the upload path
                static::createDirectoryIfNotExists($destinationPath);
    
                $fileName = $user->id . '-' . time() . '.' . $file->getClientOriginalExtension(); // Generate a unique file name
                $file->move(public_path($destinationPath), $fileName); // Move file to destination
    
                $data = $destinationPath . '/' . $fileName; // Store the file path
            }
    
            // Update user proof field
            $update = $user->update([
                'proof' => $data,
            ]);
    
            if ($update) {
                return back()->with('success', 'Proof uploaded successfully');
            }
    
            return back()->withInput()->with('error', 'Error updating profile');
        }
        
    }

    public function storeKYC(Request $request)
    {
        // dd($request->all());

        // return back()->with('success', 'Profile updated successfully');
        return redirect()->route('profile')->with('success', 'KYC stored successfully');
    }

    public function userMode(Request $request)
    {
        $user = auth()->user();

        if($user->mode == 'light')
        {
            $user->update([
                'mode' => 'dark',
            ]);
        } elseif ($user->mode == 'dark')
        {
            $user->update([
                'mode' => 'light',
            ]);
        }

        return back()->with('primary', 'User Mode Changed');
    }

    public function storeWatchlist(Request $request)
    {
        $request->validate([
            'type' => 'required|in:crypto,stocks',
            'data_id' => 'required|integer',
        ]);

        $userId = auth()->id();

        // Check if the item already exists
        $watchlist = Watchlist::where('user_id', $userId)
            ->where('type', $request->type)
            ->where('data_id', $request->data_id)
            ->first();

        if ($watchlist) {
            // If it exists, remove it (unwatch)
            $watchlist->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Item removed from your watchlist.',
            ], 200);
        } else {
            // Otherwise, add it to the watchlist
            Watchlist::create([
                'user_id' => $userId,
                'type' => $request->type,
                'data_id' => $request->data_id,
            ]);

            return response()->json([
                'status' => 'added',
                'message' => 'Item added to your watchlist.',
            ], 200);
        }
    
    }

    public function updateTwoFactorStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'two_factor' => 'required|in:enabled,disabled',
        ]);

        // Find the user and update the two_factor status
        $user = User::findOrFail($request->user_id);
        $user->two_factor = $request->two_factor;
        $user->save();

        // Return a success message
        return response()->json(['message' => 'Two-factor authentication status updated successfully.']);
    }
}
