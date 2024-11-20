<!-- STATUS AND REMARK -->
<div style="border-top: 2px solid #5ADA86;"></div>
<div class="row mt-2">
    <div class="col-lg-12 m-b30">
        <div class="widget-box">

            <button type="button" class="btn green radius-xl mt-2 me-3 mb-3" style="float: right; background-color: #5ADA86;" data-toggle="modal" data-target="#insert-note">
                <i class="fa fa-plus"></i>
                <span>&nbsp;&nbsp;ADD NOTE</span>
            </button>

            <div class="widget-inner">
                <!-- Insert Note Modal -->
                <div id="insert-note" class="modal fade" role="dialog">
                    <form class="edit-note m-b30" method="POST" enctype="multipart/form-data">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">&nbsp;Add New Note</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-12" style="padding-bottom: 15px;">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label class="col-form-label">Note Name</label>
                                                    <input class="form-control" type="text" name="note_name" placeholder="Status or Remark name" value="" required>
                                                </div>
                                                <div class="form-group col-8">
                                                    <label class="col-form-label">Module</label>
                                                    <select class="form-control" name="module" required>
                                                        <option value="" disabled selected hidden>-- Select for what module --</option>
                                                        <option value="inventory">Inventory</option>
                                                        <option value="assignment">Assignment</option>
                                                        <option value="fundcluster">Fund Cluster</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label class="col-form-label">Color</label>
                                                    <select class="form-control" name="color" required>
                                                        <option style="background-color: #5ADA86; border-radius: 20px; margin-left: 10%; margin-right: 10%" value="#5ADA86">Green</option>
                                                        <option style="background-color: red; border-radius: 20px; margin-left: 10%; margin-right: 10%" value="red">Red</option>
                                                        <option style="background-color: blue; border-radius: 20px; margin-left: 10%; margin-right: 10%" value="blue">Blue</option>
                                                        <option style="background-color: gray; border-radius: 20px; margin-left: 10%; margin-right: 10%" value="gray">Gray</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn green radius-xl outline" name="insert-note" value="Save Changes">
                                    <button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="col-1">#</th>
                                <th class="col-7">Assigned</th>
                                <th>Status or Remarks</th>
                                <th class="col-1 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($notes = $model->displayNotes())): ?>
                                <?php foreach ($notes as $key => $note): ?>
                                    <?php $note_id = $note['id']; ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo strtoupper($note['module']); ?></td>
                                        <td>
                                            <span style="font-size: 14px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']?>;">
                                                <?php echo $note['note_name']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <center>
                                                <button data-toggle="modal" data-target="#delete-<?php echo $note_id; ?>" class="btn red" style="width: 50px; height: 37px;">
                                                    <span data-toggle="tooltip" title="Delete">
                                                        <i class="ti-archive" style="font-size: 12px;"></i>
                                                    </span>
                                                </button>
                                            </center>
                                        </td>
                                    </tr>

                                    <!-- Delete Note Modal -->
                                    <div id="delete-<?php echo $note_id; ?>" class="modal fade" role="dialog">
                                        <form class="edit-profile m-b30" method="POST">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Delete Record</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <input type="hidden" name="note_id" value="<?php echo $note_id; ?>">
                                                            <div class="form-group col-12" style="padding-bottom: 15px;">
                                                                <div class="row">
                                                                    <div class="form-group col-12">
                                                                        <label class="col-form-label">Note Name</label>
                                                                        <input class="form-control" type="text" name="note_name" value="<?php echo $note['note_name']; ?>" readonly>
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label class="col-form-label">Module</label>
                                                                        <input class="form-control" type="text" name="module" value="<?php echo $note['module']; ?>" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn green radius-xl outline" name="delete-note" value="Delete" onClick="return confirm('Delete This Note?')">
                                                        <button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?> <!-- status table data endif -->

                        </tbody>
                    </table>
                </div> <!-- table-responsive -->

                <?php
                    if (isset($_POST['insert-note'])) {
                        $note_name = $_POST['note_name'];
                        $module = $_POST['module'];
                        $color = $_POST['color'];

                        $model->insertNote($note_name, $module, $color);

                        $_SESSION['successMessage'] = "New note status added succesfully!";
                        header("Location: customize.php");
                        exit();
                    }

                    if (isset($_POST['delete-note'])) {
                        $note_id = $_POST['note_id'];

                        $model->deleteNote($note_id);    
                        $_SESSION['successMessage'] = "Status note record deleted succesfully!";
                        header("Location: customize.php");
                        exit();
                    }
                ?>
                        
            </div> <!-- widget-inner -->
        </div> <!-- widget-box -->
    </div> <!-- col -->
</div> <!-- row -->
