<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <h2 class="card-header text-center">Register</h2>
                <div class="card-body">
                    <form action="<?php echo base_url('register'); ?>" method="POST">
                        <div class="row">
                            <!-- Left column: First and Last Name -->
                            <div class="col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control mb-3" value="<?php echo set_value('first_name'); ?>" id="first_name" name="first_name" required>
                                <small><?php echo form_error('first_name'); ?></small>

                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control mb-3" value="<?php echo set_value('last_name'); ?>" id="last_name" name="last_name" required>
                                <small><?php echo form_error('last_name'); ?></small>
                            </div>
                            <!-- Right column: Password and Confirm Password -->
                            <div class="col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control mb-3" id="password" name="password" minlength="8" required>
                                <small><?php echo form_error('password'); ?></small>
                                

                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control mb-3" id="confirm_password" name="confirm_password" required>
                                <small><?php echo form_error('confirm_password'); ?></small>
                            </div>
                        </div>
                        <!-- Email field below both columns -->
                        <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" name="email" required>
                            <small><?php echo form_error('email'); ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="login.php">Log In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

