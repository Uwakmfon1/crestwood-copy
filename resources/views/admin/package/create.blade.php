@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Package</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Create Package</h6>
                    <form class="forms-sample" action="{{ route('admin.packages.store') }}" id="createPackageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name"  class="form-control" value="{{ old('name') }}" id="name" placeholder="Name">
                            @error('name')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="min_amount">Min Amount</label>
                            <input type="number" name="min_amount"  class="form-control" value="{{ old('min_amount') }}" id="min_amount" placeholder="Min Amount">
                            @error('min_amount')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="max_amount">Max Amount</label>
                            <input type="number" name="max_amount"  class="form-control" value="{{ old('max_amount') }}" id="max_amount" placeholder="Max Amount">
                            @error('max_amount')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roi">ROI (%)</label>
                            <input type="number" name="roi"  class="form-control" value="{{ old('roi') }}" id="roi" placeholder="ROI">
                            @error('roi')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="milestone">Investment Method</label>
                            <input type="text" name="milestone"  class="form-control" value="{{ old('milestone') }}" id="milestone" placeholder="Enter minimum day...">
                            @error('milestone')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="duration">Investment Duration</label>
                            <select name="duration" id="duration" class="form-control">
                                <option value="days">Day(s)</option>
                                <option value="weeks">Week(s)</option>
                                <option value="months">Month(s)</option>
                                <option value="years">Year(s)</option>
                            </select>
                            @error('duration')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
                            <small class="text-muted">Allowed formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</small>
                            <div id="imageError" class="small text-danger"></div>
                            @error('image')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                            <!-- Image preview container -->
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Investment in package</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" checked class="form-check-input" name="investment" id="enabled" value="enabled">
                                    Enable
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="investment" id="disabled" value="disabled">
                                    Disable
                                </label>
                            </div>
                            @error('investment')
                                <div class="small text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="button" onclick="confirmFormSubmit('createPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2" >Create Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const errorElement = document.getElementById('imageError');
            const preview = document.getElementById('imagePreview');
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

            // Reset previous errors and hide preview
            errorElement.textContent = '';
            preview.style.display = 'none';

            if (file) {
                // Validate file type
                if (!allowedTypes.includes(file.type)) {
                    errorElement.textContent = 'Only JPEG, PNG, JPG, and GIF images are allowed.';
                    return;
                }

                // Validate file size
                if (file.size > maxSize) {
                    errorElement.textContent = 'Image size must be less than 2MB.';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Form validation before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('image');
            const errorElement = document.getElementById('imageError');
            
            if (fileInput.files.length === 0) {
                errorElement.textContent = 'Please select an image.';
                e.preventDefault();
            }
        });
    </script>

@endsection
