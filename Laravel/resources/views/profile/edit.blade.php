<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Profile</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <!-- Input data -->
                    <!-- Kolom Kiri (Form) -->
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900">Profile Information</h1>
                                            <h1 class="h6  text-gray-900 mb-4">Update your account's profile
                                                information and email address.</h1>
                                        </div>
                                        <form id="send-verification" method="post"
                                            action="{{ route('verification.send') }}">
                                            @csrf
                                        </form>
                                        <form class="user" action="{{ route('profile.update') }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <label for="name" class="ml-3 small font-weight-bold">Name</label>
                                                    <input id="name" type="text" class="form-control form-control-user"
                                                        name="name" value="{{old('name', $user->name)}}" required
                                                        readonly autocomplete="name" placeholder="Name">
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <label for="email" class="ml-3 small font-weight-bold">Email</label>
                                                    <input id="email" type="email"
                                                        class="form-control form-control-user" name="email"
                                                        value="{{ old('email', $user->email) }}" required
                                                        autocomplete="username" placeholder="Email">

                                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                                        <div>
                                                            <p class="text-sm mt-2 text-gray-800">
                                                                {{ __('Your email address is unverified.') }}

                                                                <button form="send-verification"
                                                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                    {{ __('Click here to re-send the verification email.') }}
                                                                </button>
                                                            </p>

                                                            @if (session('status') === 'verification-link-sent')
                                                                <p class="mt-2 font-medium text-sm text-green-600">
                                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <label for="display_name"
                                                        class="ml-3 small font-weight-bold">Display name</label>
                                                    <input id="display_name" type="text"
                                                        class="form-control form-control-user" name="display_name"
                                                        value="{{old('display_name', $user->display_name)}}" required
                                                        autocomplete="display_name" placeholder="Display Name">
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <label for="no_telp" class="ml-3 small font-weight-bold">Nomor
                                                        telepon</label>
                                                    <input id="no_telp" type="tel"
                                                        class="form-control form-control-user" name="no_telp"
                                                        value="{{ old('no_telp', $user->no_telp) }}" required
                                                        autocomplete="tel" placeholder="Nomor telepon">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <label for="NIK" class="ml-3 small font-weight-bold">NIK</label>
                                                    <input id="NIK" type="text" class="form-control form-control-user"
                                                        name="NIK" value="{{old('NIK', $user->NIK)}}" required
                                                        autocomplete="NIK" placeholder="NIK">
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <label for="NISN" class="ml-3 small font-weight-bold">NISN</label>
                                                    <input id="NISN" type="text" class="form-control form-control-user"
                                                        name="NISN" value="{{ old('NISN', $user->NISN) }}" required
                                                        autocomplete="NISN" placeholder="NISN">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info btn-user btn-block">Save</button>
                                            @if (session('status') === 'profile-updated')
                                                <p x-data="{ show: true }" x-show="show" x-transition
                                                    x-init="setTimeout(() => show = false, 2000)"
                                                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                            @endif
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900">Update Password</h1>
                                            <h1 class="h6 text-gray-900 mb-4">Ensure your account is using a
                                                long, random password to stay secure.</h1>
                                        </div>
                                        <form class="user" action="{{ route('password.update') }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="update_password_current_password"
                                                    class="ml-3 small font-weight-bold">Current Password</label>
                                                <input id="update_password_current_password" type="password"
                                                    class="form-control form-control-user" name="current_password"
                                                    required autocomplete="current-password"
                                                    placeholder="Current Password">
                                            </div>
                                            <div class="form-group row">
                                                <label for="update_password_password"
                                                    class="ml-3 small font-weight-bold">New Password</label>
                                                <input id="update_password_password" type="password"
                                                    class="form-control form-control-user" name="password" required
                                                    autocomplete="new-password" placeholder="New Password">
                                            </div>
                                            <div class="form-group row">
                                                <label for="update_password_password_confirmation"
                                                    class="ml-3 small font-weight-bold">Confirm Password</label>
                                                <input id="update_password_password_confirmation" type="password"
                                                    class="form-control form-control-user" name="password_confirmation"
                                                    required autocomplete="new-password" placeholder="Confirm Password">
                                            </div>
                                            <button type="submit" class="btn btn-info btn-user btn-block">Save</button>
                                            @if (session('status') === 'password-updated')
                                                <p x-data="{ show: true }" x-show="show" x-transition
                                                    x-init="setTimeout(() => show = false, 2000)"
                                                    class="text-sm text-gray-900">{{ __('Saved.') }}</p>
                                            @endif
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900">Delete Account</h1>
                                            <h1 class="h6 text-gray-900 mb-4">Once your account is deleted, all
                                                of its resources and data will be permanently deleted. Before deleting
                                                your account, please download any data or information that you wish to
                                                retain.</h1>
                                        </div>
                                        <!-- Trigger -->
                                        <x-danger-button x-data
                                            x-on:click="$dispatch('open-modal', 'confirm-user-deletion')"
                                            class="btn btn-danger">
                                            {{ __('Delete Account') }}
                                        </x-danger-button>

                                        <!-- Notification Style Modal -->
                                        <x-modal name="confirm-user-deletion"
                                            :show="$errors->userDeletion->isNotEmpty()" focusable>
                                            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto text-center">
                                                <h2 class="text-lg font-semibold text-gray-800 mb-2">
                                                    {{ __('Are you sure?') }}
                                                </h2>
                                                <p class="text-sm text-gray-500 mb-4">
                                                    {{ __('Once deleted, all your data will be permanently removed. Please enter your password to continue.') }}
                                                </p>

                                                <form method="post" action="{{ route('profile.destroy') }}"
                                                    class="space-y-4">
                                                    @csrf
                                                    @method('delete')

                                                    <input type="password" name="password"
                                                        placeholder="{{ __('Password') }}"
                                                        class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring focus:ring-red-300"
                                                        required />
                                                    <div class="flex justify-center gap-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Cancel') }}
                                                        </x-secondary-button>

                                                        <x-danger-button class="btn btn-danger">
                                                            {{ __('Delete') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </x-modal>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('layouts.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="//unpkg.com/alpinejs" defer></script>


</body>

</html>
