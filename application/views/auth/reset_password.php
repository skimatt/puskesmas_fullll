<!doctype html>
<html
  lang="id"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path=""
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <base href="<?= base_url('assets/'); ?>">
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= isset($title) ? htmlspecialchars($title) : 'Reset Password - Puskesmas Digital'; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="vendor/libs/typeahead-js/typeahead.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="vendor/css/pages/page-auth.css" />

    <!-- Custom CSS untuk form kompak -->
    <style>
      .compact-form .form-label { font-size: 0.75rem; margin-bottom: 0.25rem; }
      .compact-form .form-control, .compact-form select { height: 2rem; padding: 0.25rem 0.5rem; font-size: 0.8rem; }
      .compact-form .form-select { height: 2rem; padding: 0.25rem 0.5rem; font-size: 0.8rem; }
      .compact-form textarea { height: 3rem; font-size: 0.8rem; }
      .compact-form .input-group-text { padding: 0.25rem 0.5rem; }
      .compact-form .mb-2 { margin-bottom: 0.5rem !important; }
      .compact-form .text-danger { font-size: 0.7rem; }
      .compact-form .btn { padding: 0.4rem; font-size: 0.9rem; }
      .compact-form .alert { padding: 0.5rem; font-size: 0.8rem; }
      .compact-form .alert .btn-close { padding: 0.5rem; }
    </style>

    <!-- Helpers -->
    <script src="vendor/js/helpers.js"></script>
    <script src="vendor/js/template-customizer.js"></script>
    <script src="js/config.js"></script>
  </head>
  <body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="index.html" class="app-brand auth-cover-brand">
        <span class="app-brand-logo demo">
          <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
              fill="#7367F0" />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
              fill="#161616" />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
              fill="#161616" />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
              fill="#7367F0" />
          </svg>
        </span>
        <span class="app-brand-text demo text-heading fw-bold">Puskesmas Digital</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-8 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="img/illustrations/auth-register-illustration-light.png"
              alt="auth-reset-cover"
              class="my-5 auth-illustration"
              data-app-light-img="illustrations/auth-register-illustration-light.png"
              data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
            <img
              src="img/illustrations/bg-shape-image-light.png"
              alt="auth-reset-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png"
              data-app-dark-img="illustrations/bg-shape-image-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Reset Password -->
        <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-6 p-4">
          <div class="w-px-400 mx-auto">
            <h4 class="mb-1"><i class="fas fa-lock mr-2"></i> Reset Password - Puskesmas Digital</h4>
            <p class="mb-2">Masukkan password baru untuk akun Anda.</p>

            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible mb-2 compact-form" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('message')): ?>
              <div class="alert alert-success alert-dismissible mb-2 compact-form" role="alert">
                <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if (validation_errors()): ?>
              <div class="alert alert-danger alert-dismissible mb-2 compact-form" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= validation_errors(); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <?= form_open('auth/reset_password/' . $token, ['id' => 'formResetPassword', 'class' => 'mb-2 compact-form']); ?>
              <div class="mb-2 form-password-toggle">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    required
                    minlength="8"
                    placeholder="Masukkan password baru" />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
                <span id="password-error" class="text-danger" style="font-size: 0.7rem;"></span>
                <?= form_error('password', '<p class="text-danger" style="font-size: 0.7rem;">', '</p>'); ?>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">
                <i class="fas fa-key mr-2"></i> Reset Password
              </button>
            <?= form_close(); ?>

            <p class="text-center mt-2">
              Kembali ke <a href="<?= base_url('auth/login'); ?>" class="text-primary">Login</a>
            </p>
          </div>
        </div>
        <!-- /Reset Password -->
      </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="vendor/libs/jquery/jquery.js"></script>
    <script src="vendor/libs/popper/popper.js"></script>
    <script src="vendor/js/bootstrap.js"></script>
    <script src="vendor/libs/node-waves/node-waves.js"></script>
    <script src="vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/libs/hammer/hammer.js"></script>
    <script src="vendor/libs/i18n/i18n.js"></script>
    <script src="vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="vendor/js/menu.js"></script>

    <!-- Main JS -->
    <script src="js/main.js"></script>

    <!-- Password Validation Script -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formResetPassword');
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('password-error');

        // Validasi password secara real-time
        passwordInput.addEventListener('input', function () {
          const password = this.value;
          if (password.length < 8) {
            passwordError.textContent = 'Password minimal 8 karakter.';
          } else {
            passwordError.textContent = '';
          }
        });

        // Debugging submit form
        form.addEventListener('submit', function (event) {
          console.log('Submit button clicked');
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Form validation failed');
            form.classList.add('was-validated');
          } else {
            console.log('Form is valid, submitting to auth/reset_password');
          }
        });
      });
    </script>
  </body>
</html>