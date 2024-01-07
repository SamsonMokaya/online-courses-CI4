
    <?php $isActive = isset($isActive) ? $isActive : false; ?>
    <?php if ($loggedIn): ?>
        <?php if ($isActive): ?>
            <!-- Form for Deactivating Account -->
            <form id="deactivateForm" action="/status" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="status" value="inactive">
                <button type="submit" class="btn btn-danger">Deactivate Account</button>
            </form>
        <?php else: ?>
            <!-- Form for Activating Account -->
            <form id="activateForm" action="/status" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="status" value="active">
                <button type="submit" class="btn btn-success">Activate Account</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <h2>Available Courses</h2>

    <div class="row mt-4">
        <?php foreach ($courses as $course): ?>
            <?php if (!$loggedIn && $course['Type'] === 'Free'): ?>
                <!-- Display Free courses only for non-logged-in users -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($course['Title']) ?></h5>
                            <p class="card-text"><?= esc($course['Description']) ?></p>
                            <p class="card-text"><strong>Duration:</strong> <?= esc($course['Duration']) ?></p>
                        </div>
                    </div>
                </div>
            <?php elseif ($loggedIn && $isActive): ?>
                <!-- Display all courses for logged-in users with active status -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($course['Title']) ?></h5>
                            <p class="card-text"><?= esc($course['Description']) ?></p>
                            <p class="card-text"><strong>Duration:</strong> <?= esc($course['Duration']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
