<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id' => 1,
                'name' => 'High-Yield Savings Account (HYSA)',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/54nn41qg/propel-savings_500x500.png',
                'btnText' => 'Start Savings',
                'modalId' => 'modalHYSA',
                'questions' => [
                    [
                        'question' => 'What is your primary goal for this savings account?',
                        'answers' => [
                            'Build an emergency fund',
                            'Earn higher interest on savings',
                            'Save for future large purchases (e.g., home, car)',
                        ]
                    ],
                    [
                        'question' => 'What is your expected contribution amount?',
                        'answers' => [
                            'Less than $500/month',
                            '$500 – $1,000/month',
                            'Over $1,000/month',
                        ]
                    ],
                    [
                        'question' => 'How long do you plan to keep your savings in this account?',
                        'answers' => [
                            'Less than 1 year',
                            '1–3 years',
                            'Over 3 years',
                        ]
                    ],
                    [
                        'question' => 'Do you need frequent access to the funds, or can they remain untouched?',
                        'answers' => [
                            'Frequent access needed',
                            'No access required for now',
                        ]
                    ],
                    [
                        'question' => 'Would you like to reinvest interest into the account or withdraw it periodically?',
                        'answers' => [
                            'Reinvest interest',
                            'Withdraw interest periodically',
                        ]
                    ]
                ]
            ],
            [
                'id' => 2,
                'name' => 'Cash Interest Account',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/zpfjqqui/no-fees_500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalCashInterest',
                'questions' => [
                    [
                        'question' => 'What is the purpose of this cash account?',
                        'answers' => [
                            'Maintain liquidity with interest growth',
                            'Short-term cash management for upcoming expenses',
                            'Long-term capital preservation with flexible access',
                        ]
                    ],
                    [
                        'question' => 'How often do you plan to deposit funds into this account?',
                        'answers' => [
                            'Weekly',
                            'Monthly',
                            'Irregularly',
                        ]
                    ],
                    [
                        'question' => 'Do you need frequent access to these funds?',
                        'answers' => [
                            'Yes, I’ll need regular access',
                            'No, I can leave the funds untouched',
                        ]
                    ],
                    [
                        'question' => 'Would you like a portion of this account to be allocated to higher interest products?',
                        'answers' => [
                            'Yes, maximize growth on a portion of funds',
                            'No, keep everything liquid',
                        ]
                    ]
                ]
            ],
            [
                'id' => 3,
                'name' => 'Tax-Free Savings Account',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/a0jeky3a/cash_2024_500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalTaxFree',
                'questions' => [
                    [
                        'question' => 'What is your primary goal for this tax-free savings account?',
                        'answers' => [
                            'Save for education or long-term projects',
                            'Maximize tax-free growth',
                            'Build long-term savings for retirement or specific milestones',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to contribute each year?',
                        'answers' => [
                            'Less than $5,000',
                            '$5,000 – $10,000',
                            'Over $10,000',
                        ]
                    ],
                    [
                        'question' => 'What is your expected time horizon for this account?',
                        'answers' => [
                            'Less than 5 years',
                            '5–10 years',
                            'Over 10 years',
                        ]
                    ],
                    [
                        'question' => 'Do you prefer to reinvest all earnings into the account or withdraw them as they accumulate?',
                        'answers' => [
                            'Reinvest all earnings',
                            'Withdraw earnings periodically',
                        ]
                    ]
                ]
            ],
            [
                'id' => 4,
                'name' => 'First Home Savings Account',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/3junkeko/transfer-money-500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalFirstHome',
                'questions' => [
                    [
                        'question' => 'When do you plan to purchase your first home?',
                        'answers' => [
                            'Within 1 year',
                            '1–3 years',
                            'Over 3 years',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to save for a home down payment?',
                        'answers' => [
                            'Less than $50,000',
                            '$50,000 – $100,000',
                            'Over $100,000',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to contribute monthly toward this goal?',
                        'answers' => [
                            'Less than $500',
                            '$500 – $1,000',
                            'Over $1,000',
                        ]
                    ],
                    [
                        'question' => 'Do you need to access these funds before reaching your savings goal?',
                        'answers' => [
                            'Yes, I may need access',
                            'No, I plan to leave the funds untouched',
                        ]
                    ],
                    [
                        'question' => 'Would you like financial advice on home-buying incentives and tax benefits?',
                        'answers' => [
                            'Yes',
                            'No',
                        ]
                    ]
                ]
            ],
            [
                'id' => 5,
                'name' => 'Corporate Accounts',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/0axfwoe2/lock-security-500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalCorporate',
                'questions' => [
                    [
                        'question' => 'What is the primary purpose of this corporate account?',
                        'answers' => [
                            'Cash flow management for operations',
                            'Capital preservation for business investments',
                            'Employee benefit funding (e.g., 401(k) or pensions)',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to deposit into this account monthly?',
                        'answers' => [
                            'Less than $10,000',
                            '$10,000 – $50,000',
                            'Over $50,000',
                        ]
                    ],
                    [
                        'question' => 'Do you require frequent access to corporate funds?',
                        'answers' => [
                            'Yes, for daily operations',
                            'No, funds can remain untouched',
                        ]
                    ],
                    [
                        'question' => 'Would you like a portion of corporate funds to be invested for long-term growth?',
                        'answers' => [
                            'Yes, allocate a portion to investments',
                            'No, keep all funds in cash reserves',
                        ]
                    ]
                ]
            ],
            [
                'id' => 6,
                'name' => 'Retirement Accounts (Roth IRA)',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/xf5p3zer/click_desktop_500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalRetirement',
                'questions' => [
                    [
                        'question' => 'What is your goal with this Roth IRA?',
                        'answers' => [
                            'Tax-free growth for retirement',
                            'Maximize savings for long-term retirement needs',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to contribute each year?',
                        'answers' => [
                            'Less than $6,500',
                            '$6,500 – $15,000 (catch-up contributions for age 50+)',
                        ]
                    ],
                    [
                        'question' => 'When do you expect to start withdrawing from the account?',
                        'answers' => [
                            'Before age 59 ½',
                            'After age 59 ½',
                        ]
                    ],
                    [
                        'question' => 'Would you prefer automatic monthly or annual contributions?',
                        'answers' => [
                            'Monthly',
                            'Annually',
                        ]
                    ]
                ]
            ]
        ];

        foreach ($plans as $planData) {
            // Create the plan
            $plan = Plan::create([
                'id' => $planData['id'],
                'name' => $planData['name'],
                'description' => $planData['sub_name'],
                'img' => $planData['img'],
                'modalId' => $planData['modalId'],
            ]);

            // Create the questions for the plan
            foreach ($planData['questions'] as $questionData) {
                $question = Question::create([
                    'plan_id' => $plan->id,
                    'text' => $questionData['question'],
                ]);

                // Create the answers for the question
                foreach ($questionData['answers'] as $answerText) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text' => $answerText,
                    ]);
                }
            }
        }
    }
}
