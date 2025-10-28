<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <h2 class="card-header text-center">Login</h2>
                <div class="card-body">
                    <form action="<?php echo site_url('myauth/login'); ?>" method="POST">
                        <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" name="email" required>
                            <small><?php echo form_error('email'); ?></small>
                        </div>    

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="8">
                            <small><?php echo form_error('password'); ?></small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <?php if($this->session->flashdata('status')): ?>
                        <p class="text-danger mt-2"><?= $this->session->flashdata('status'); ?></p>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <p>Don't have an account? 
                            <a href="register.php"> Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
