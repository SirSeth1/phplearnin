    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <div class="card">
                <div class="card-header">
                    <h5>
                    How to insert Employee data into db
                    <a href="<?php echo base_url('employee'); ?>" class="btn btn-danger float-right">BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                <form action="<?php echo base_url('employee/store'); ?>" method="post">
                    <div class="form-group">
                        <label for="">First Name</label>
                       <input type="text" class="form-control" name="first_name" placeholder="Employee Name">
                       <small><?php echo form_error('first_name'); ?></small>
                    </div>

                    <div class="form-group">
                        <label for="">Last Name</label>
                       <input type="text" class="form-control" name="last_name" placeholder="Employee Name">
                       <small><?php echo form_error('last_name'); ?></small>
                    </div>

                    <div class="form-group">
                        <label for="">Phone number</label>
                       <input type="text" class="form-control" name="phone" placeholder="Employee Phone Number">
                       <small><?php echo form_error('phone'); ?></small>
                    </div>

                    <div class="form-group">
                        <label for="">Email Id</label>
                       <input type="text" class="form-control" name="email" placeholder="Employee Email">
                       <small><?php echo form_error('email'); ?></small>
                    </div>
                    
                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
                </div>
               </div> 
            </div>
        </div>
    </div>

   

   