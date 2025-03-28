
<?php 
    include ('../Config/layout.php');
    ?>
  



    <div class="container">
          <div class="page-inner">

          
          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">User List</h4>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Add a new User</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Actions</th>
                          
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                          <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Actions</th>
                          </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            include ('../Config/connecttodb.php');
                            $sql = "SELECT * FROM user";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$row["Fname"]." ".$row['Minitial']." ".$row['Lname']."</td>";
                                echo "<td>".$row["Username"]."</td>";
                                echo "<td>".$row["Password"]."</td>";
                                echo "<td>".$row["Type"]."</td>";
                                echo "<td>";
                                echo "<a href='#' class='btn btn-link btn-primary btn-lg' data-bs-toggle='modal' data-bs-target='#editUserModal' 
                                        data-id='".$row["User_ID"]."' 
                                        data-username='".$row["Username"]."' 
                                        data-fname='".$row["Fname"]."' 
                                        data-lname='".$row["Lname"]."' 
                                        data-minitial='".$row["Minitial"]."' 
                                        data-gender='".$row["Gender"]."' 
                                        data-age='".$row["Age"]."' 
                                        data-contact='".$row["Contact"]."' 
                                        data-email='".$row["Email"]."' 
                                        data-department='".$row["Department"]."'
                                       data-type='".$row["Type"]."' >
                                        <i class='fa fa-edit'></i>
                                      </a>";
                                echo "<a href='UserController.php?user_id=".$row["User_ID"]."' type='button' class='btn btn-link btn-danger delete-btn'>";
                                echo "<i class='fa fa-times'></i>";
                                echo "</a>";
                                echo "</td>";
                                echo "</tr>";
                                }
                            } else {
                                echo "0 results";
                            }
                            $conn->close();

                            ?>
                        
                          </tbody>
                        </table>
                        </div>
                 </div>
        </div>
   

    <!-- create Student Modal -->
     <!-- Bootstrap Modal -->
<<!-- Bootstrap Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="UserController.php" method="POST">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First name" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last name" required>
                            </div>
                            <div class="form-group">
                                <label for="minitial">Middle Initial</label>
                                <input type="text" class="form-control" id="minitial" name="minitial" placeholder="Enter Middle Initial">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                           
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact Number" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department" required>
                            </div>
                            <div class="form-group">
                                <label for="Type">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Student">Student</option>
                                    <option value="Teacher">Teacher</option>
                                </select>
                            </div>
                    
                        </div>

                    </div>
                    <div class="card-action ms-auto me-auto" style="text-align: center;">
                        <button type="submit" class="btn btn-success" name="saveUser">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of create student modal -->
 <!-- Edit Student Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="UserController.php" method="POST">
                    <input type="hidden" id="editUserID" name="user_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editUsername">Username</label>
                                <input type="text" class="form-control" id="editUsername" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="editPassword">New Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" id="editPassword" name="password">
                            </div>
                            <div class="form-group">
                                <label for="editFname">First Name</label>
                                <input type="text" class="form-control" id="editFname" name="fname" required>
                            </div>
                            <div class="form-group">
                                <label for="editLname">Last Name</label>
                                <input type="text" class="form-control" id="editLname" name="lname" required>
                            </div>
                            <div class="form-group">
                                <label for="editMinitial">Middle Initial</label>
                                <input type="text" class="form-control" id="editMinitial" name="minitial">
                            </div>
                            <div class="form-group">
                                <label for="editGender">Gender</label>
                                <select class="form-control" id="editGender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="editAge">Age</label>
                                <input type="number" class="form-control" id="editAge" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="editContact">Contact</label>
                                <input type="text" class="form-control" id="editContact" name="contact" required>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="editDepartment">Department</label>
                                <input type="text" class="form-control" id="editDepartment" name="department" required>
                            </div>
                            <div class="form-group">
                                <label for="editType">Type</label>
                                <select class="form-control" id="editType" name="Type" required>
                                    <option value="">Select Type</option>
                                    <option value="Student">Student</option>
                                    <option value="Teacher">Teacher</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-action ms-auto me-auto" style="text-align: center;">
                        <button type="submit" class="btn btn-success" name="editUser">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



</div>
</div>
<!-- script for edit moda -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var editModal = document.getElementById("editUserModal");
    editModal.addEventListener("show.bs.modal", function (event) {
        var button = event.relatedTarget;
        
        document.getElementById("editUserID").value = button.getAttribute("data-id");
        document.getElementById("editUsername").value = button.getAttribute("data-username");
        document.getElementById("editFname").value = button.getAttribute("data-fname");
        document.getElementById("editLname").value = button.getAttribute("data-lname");
        document.getElementById("editMinitial").value = button.getAttribute("data-minitial");
        document.getElementById("editGender").value = button.getAttribute("data-gender");
        document.getElementById("editAge").value = button.getAttribute("data-age");
        document.getElementById("editContact").value = button.getAttribute("data-contact");
        document.getElementById("editEmail").value = button.getAttribute("data-email");
        document.getElementById("editDepartment").value = button.getAttribute("data-department");
        document.getElementById("editType").value = button.getAttribute("data-Type");
    });
});

</script>
<!-- script for notif alert  -->
<script>
    // Check if there is a message in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');

    if (message === 'created') {
        swal({
            title: "Success!",
            text: "New user record created successfully!",
            icon: "success"
        }).then(() => {
            window.location.href = "Userindex.php"; // Removes message from URL
        });
    } else if (message === 'error') {
        swal({
            title: "Error!",
            text: "Failed to create user record.",
            icon: "error"
        }).then(() => {
            window.location.href = "Userindex.php";
        });
    }
    if (message === 'deleted') {
        swal({
            title: "Success!",
            text: "User record deleted successfully!",
            icon: "success"
        }).then(() => {
            window.location.href = "Userindex.php"; // Removes message from URL
        });
    } else if (message === 'error') {
        swal({
            title: "Error!",
            text: "Failed to delete user record.",
            icon: "error"
        }).then(() => {
            window.location.href = "Userindex.php";
        });
    }
    if (message === 'updated') {
        swal({
            title: "Success!",
            text: "User record updated successfully!",
            icon: "success"
        }).then(() => {
            window.location.href = "Userindex.php"; // Removes message from URL
        });
    } else if (message === 'error') {
        swal({
            title: "Error!",
            text: "Failed to update User record.",
            icon: "error"
        }).then(() => {
            window.location.href = "Userindex.php";
        });
    }

</script>
<!-- script for alert -->
<script>
    
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            let deleteUrl = this.getAttribute("href");

            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-success",
                    },
                    cancel: {
                        visible: true,
                        className: "btn btn-danger",
                    },
                },
            }).then((confirmDelete) => {
                if (confirmDelete) {
                    window.location.href = deleteUrl; // Redirect to delete URL
                } else {
                    swal.close();
                }
            });
        });
    });
});
</script>


<!-- script for datatable -->
<script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
      });
    </script>