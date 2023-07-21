<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div id="body" class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div id="form-wrapper" class="container">
        <div class="text-center">
            <h1 class="fw-bold mb-4" style="font-size: 35px">Login</h1>
            <h2 class="mb-4" style="font-size: 20px">Welcome back</h2>
        </div>

        <div class="pb-3 text-center">
            <?= anchor('Account/Register', 'Join') ?>
        </div>

        <form method="POST" action="<?= site_url('Account/SubmitLogin') ?>">
            <div class="form-group mb-1">
                <label class="form-label" for="login">Login:</label>
                <input name="login" id="login" class="form-control" placeholder="login" required/>
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password">Password:</label>
                <input name="password" id="password" type="password" class="form-control" placeholder="••••••••"
                       required/>
            </div>
            <div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary text-nowrap fw-bold w-100"
                        style="border-radius: 2px; padding: 7px 0;  font-size: 18px">
                    Login
                </button>
            </div>
        </form>

    </div>
</div>
<?= $this->endSection() ?>