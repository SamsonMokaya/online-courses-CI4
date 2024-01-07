<div class="container mt-5">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Subscribe
    </button>
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
            <?php elseif ($loggedIn): ?>
                <!-- Display all courses for logged-in users -->
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
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/subscribe-payment" method="post">
             <?= csrf_field() ?>
            <label for="package">Select Package:</label>
            <select name="amount" id="package" class="form-control" required>
                <option value="20">$20 Package (10 Courses)</option>
                <option value="23">$23 Package (14 Courses)</option>
            </select>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" class="form-control" required>

            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
</div>