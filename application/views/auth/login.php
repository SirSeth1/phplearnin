<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <h2 class="card-header text-center">Login</h2>
                <div class="card-body">
                    <form action="<?php echo base_url('login'); ?>" method="POST">
                    <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" name="email" required>
                            <small><?php echo form_error('email'); ?></small>
                        </div>    
                    
                    <div class="row">
                            
                            <div class="col-md-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control mb-3" id="password" name="password" minlength="8" required>
                                <small><?php echo form_error('password'); ?></small>
                                

                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control mb-12" id="confirm_password" name="confirm_password" required>
                                <small><?php echo form_error('confirm_password'); ?></small>
                            </div>
                        </div>
                   
                       <h5> </h5> 
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="register.php">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

