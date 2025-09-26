<div class="container">
        <div class="row">
            <div class="col-md-12">
               <div class="card">
                <div class="card-header">
                <?php if($this->session->flashdata('status')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('status'); ?>
                    </div>
                    <?php endif; ?>
                    <h5>
                    How to fetch Employee data from db
                    <a href="<?php echo base_url('employee/add'); ?>" class="btn btn-primary float-right">Add Employee</a>
                    </h5>
                </div>
                <div class="card-body">
                    <table id="datatable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone Number</th>
                                <th>Email ID</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Confirm Delete</th>
                            </tr>
                        </thead>


                        <tbody>
                        <?php
                        foreach ($employee as $row):
                        ?>
                        
                        <tr>
                            <td> <?php echo $row->id; ?></td>
                            <td> <?= $row->first_name ?></td>
                            <td><?= $row->last_name ?></td>
                            <td><?= $row->phone ?></td>
                            <td><?= $row->email ?></td>
                            <td>
                                <a href="<?php echo base_url('employee/edit/'.$row->id); ?>" class="btn btn-success btn-sm">Edit</a>
                            </td>
                            <td>
                                <a href="<?php echo base_url('employee/delete/'.$row->id); ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                            <td><button type="button" class="btn btn-warning btn-sm confirm-delete" value="<?php echo $row->id; ?>">Confirm Delete</button></td>
                        </tr>
                         <?php endforeach; ?>
                            <!-- <?php if(!empty($employees)): ?>
                                <?php foreach($employees as $employee): ?>
                                    <tr>
                                        <td><?php echo $employee->id; ?></td>
                                        <td><?php echo $employee->first_name; ?></td>
                                        <td><?php echo $employee->last_name; ?></td>
                                        <td><?php echo $employee->phone_number; ?></td>
                                        <td><?php echo $employee->email; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('employee/edit/'.$employee->id); ?>" class="btn btn-warning">Edit</a>
                                            <a href="<?php echo base_url('employee/delete/'.$employee->id); ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No employees found</td>
                                </tr>
                            <?php endif; ?> -->
                        </tbody>
                    </table>
                </div>
               </div> 
            </div>
        </div>
    </div>



