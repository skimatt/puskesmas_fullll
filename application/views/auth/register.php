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

    <title><?= isset($title) ? htmlspecialchars($title) : 'Registrasi - Puskesmas Digital'; ?></title>

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
      <a href="http://localhost/puskesmas/" class="app-brand auth-cover-brand">
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
              alt="auth-register-cover"
              class="my-5 auth-illustration"
              data-app-light-img="illustrations/auth-register-illustration-light.png"
              data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
            <img
              src="img/illustrations/bg-shape-image-light.png"
              alt="auth-register-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png"
              data-app-dark-img="illustrations/bg-shape-image-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Register -->
        <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-6 p-4">
          <div class="w-px-400 mx-auto">
            <h4 class="mb-1"><i class="fas fa-clinic-medical mr-2"></i> Registrasi - Puskesmas Digital</h4>
            <p class="mb-2">Buat akun Anda untuk mulai menggunakan layanan kami!</p>

            <?php if ($this->session->flashdata('message')): ?>
              <div class="alert alert-success alert-dismissible mb-2 compact-form" role="alert">
                <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible mb-2 compact-form" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <?= form_open('auth/register', ['id' => 'formAuthentication', 'class' => 'mb-2 compact-form']); ?>
              <div class="row g-2">
                <div class="col-md-6 mb-2">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input type="text" name="nama" id="nama" value="<?= set_value('nama'); ?>" class="form-control" required />
                  <?= form_error('nama', '<p class="text-danger">', '</p>'); ?>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" name="email" id="email" value="<?= set_value('email'); ?>" class="form-control" required />
                  <?= form_error('email', '<p class="text-danger">', '</p>'); ?>
                </div>
                <div class="col-md-6 mb-2 form-password-toggle">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group input-group-merge">
                    <input type="password" name="password" id="password" class="form-control" required />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                  <?= form_error('password', '<p class="text-danger">', '</p>'); ?>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="no_kk" class="form-label">No. KK</label>
                  <input type="text" name="no_kk" id="no_kk" value="<?= set_value('no_kk'); ?>" class="form-control" required pattern="\d{16}" />
                  <?= form_error('no_kk', '<p class="text-danger">', '</p>'); ?>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="no_ktp" class="form-label">No. KTP</label>
                  <input type="text" name="no_ktp" id="no_ktp" value="<?= set_value('no_ktp'); ?>" class="form-control" required pattern="\d{16}" />
                  <?= form_error('no_ktp', '<p class="text-danger">', '</p>'); ?>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?= set_value('tanggal_lahir'); ?>" class="form-control" required />
                </div>
                <div class="col-md-6 mb-2">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="L" <?= set_select('jenis_kelamin', 'L'); ?>>Laki-laki</option>
                    <option value="P" <?= set_select('jenis_kelamin', 'P'); ?>>Perempuan</option>
                  </select>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="no_telepon" class="form-label">No. Telepon</label>
                  <input type="text" name="no_telepon" id="no_telepon" value="<?= set_value('no_telepon'); ?>" class="form-control" required pattern="\d+" />
                </div>
                <div class=" col-md-6 mb-2">
                  <label for="nomor_bpjs" class="form-label">Nomor BPJS</label>
                  <input type="text" name="nomor_bpjs" id="nomor_bpjs" value="<?= set_value('nomor_bpjs'); ?>" class="form-control" />
                </div>
                <div class="col-md-6 mb-2">
                  <label for="golongan_darah" class="form-label">Golongan Darah</label>
                  <select name="golongan_darah" id="golongan_darah" class="form-select">
                    <option value="" <?= set_select('golongan_darah', ''); ?>>Pilih</option>
                    <option value="A" <?= set_select('golongan_darah', 'A'); ?>>A</option>
                    <option value="B" <?= set_select('golongan_darah', 'B'); ?>>B</option>
                    <option value="AB" <?= set_select('golongan_darah', 'AB'); ?>>AB</option>
                    <option value="O" <?= set_select('golongan_darah', 'O'); ?>>O</option>
                  </select>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="agama" class="form-label">Agama</label>
                  <input type="text" name="agama" id="agama" value="<?= set_value('agama'); ?>" class="form-control" required />
                </div>
                <div class="col-md-6 mb-2">
                  <label for="pekerjaan" class="form-label">Pekerjaan</label>
                  <input type="text" name="pekerjaan" id="pekerjaan" value="<?= set_value('pekerjaan'); ?>" class="form-control" required />
                </div>
                
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">
                <i class="fas fa-user-plus mr-2"></i> Daftar
              </button>
            <?= form_close(); ?>

            <p class="text-center mt-2">
              <span>Sudah punya akun?</span>
              <a href="<?= base_url('auth/login'); ?>">
                <span>Login</span>
              </a>
            </p>

            <div class="divider my-2">
              <div class="divider-text">atau</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
                <i class="tf-icons ti ti-brand-facebook-filled"></i>
              </a>
              <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-twitter me-1_5">
                <i class="tf-icons ti ti-brand-twitter-filled"></i>
              </a>
              <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-github me-1_5">
                <i class="tf-icons ti ti-brand-github-filled"></i>
              </a>
              <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-google-plus">
                <i class="tf-icons ti ti-brand-google-filled"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Register -->
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

    <!-- Simplified Submit Script -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formAuthentication');
        form.addEventListener('submit', function (event) {
          console.log('Submit button clicked');
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Form validation failed');
            form.classList.add('was-validated');
          } else {
            console.log('Form is valid, submitting to auth/register');
          }
        });
      });
    </script>
  </body>
</html>