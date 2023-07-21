<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Hotels</h2>

    <!-- Filter options -->
    <form method="get">
        <div class="form-group">
            <label for="city">City:</label>
            <select class="form-control" id="city" name="city">
                <option value="">All</option>
                <?php if (!empty($cities)): ?>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= esc($city->name) ?>" <?= ($city->name == @$_GET['city']) ? 'selected' : '' ?>><?= esc($city->name) ?></option>
                    <?php endforeach; endif; ?>

            </select>
        </div>
        <div class="form-group">
            <label for="stars">Stars:</label>
            <select class="form-control" id="stars" name="stars">
                <option value="">All</option>
                <?php if (!empty($stars)): ?>
                    <?php foreach ($stars as $star): ?>
                        <option value="<?= esc($star) ?>" <?= ($star == @$_GET['stars']) ? 'selected' : '' ?>><?= esc($star) ?></option>
                    <?php endforeach; endif; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filter</button>
    </form>

    <!-- List of hotels -->
    <div class="row mt-3">
        <?php if (!empty($hotels)): ?>
            <?php foreach ($hotels as $hotel): ?>
                <div class="col-sm-4">
                    <div class="card">
                        <?php
                        helper('html');
                        echo img($hotel->imagePath);
                        ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($hotel->name) ?></h5>
                            <p class="card-text"><?= esc($hotel->countryName) ?>, <?= esc($hotel->cityName) ?></p>
                            <p class="card-text"><?= str_repeat('★', $hotel->stars) ?></p>
                            <p class="card-text">$<?= esc($hotel->cost) ?></p>
                            <p class="card-text"><?= esc($hotel->info) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
    </div>
</div>

<?= $this->endSection() ?>