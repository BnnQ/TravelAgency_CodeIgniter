<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div id="body" class="container d-flex align-items-center justify-content-center p-0 min-vh-100 w-100 ">
    <div id="form-wrapper" class="container-fluid">
        <div class="text-center">
            <h1 class="fw-bold mb-4" style="font-size: 35px">Join TravelUp</h1>
            <h2 class="mb-4 label-sm text-light-gray">Already have an account? <?= anchor('Account/Login', 'Login') ?>
            </h2>
        </div>

        <form method="POST" action="<?= site_url('Account/SubmitRegister') ?>">
            <div class="row mb-1">
                <div class="form-group">
                    <label class="form-label" for="login">Login</label>
                    <input name="login" id="login" class="form-control" required/>
                </div>
            </div>
            <div class="row mb-1">
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input name="email" id="email" type="email" class="form-control"
                           placeholder="example@mail.com" required/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input name="password" id="password" type="password"
                           class="form-control"
                           placeholder="••••••••" required/>
                </div>
            </div>

            <div>
                <button type="submit" name="submit" id="submit"
                        class="btn btn-primary text-nowrap fw-bold w-100"
                        style="border-radius: 2px; padding: 7px 0;  font-size: 18px">
                    Join
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>