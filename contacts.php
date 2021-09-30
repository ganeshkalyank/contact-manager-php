<?php
    // version 1.1
    $conn = new mysqli("localhost", "DATABASE_USER", "DATABASE_USER_PASSWORD", "DATABASE_NAME");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->query("CREATE TABLE IF NOT EXISTS `contacts` (`id` int(11) NOT NULL auto_increment, `name` varchar(255) NOT NULL, `mobile` varchar(13) NOT NULL, `email` varchar(255) NOT NULL, primary key (id))");
    if (isset($_POST["new_contact"])) {
        $name = $_POST["name"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];
        $new_contact = "INSERT INTO contacts (name, mobile, email) VALUES ('$name', '$mobile', '$email')";
        $conn->query($new_contact);
    }
    if(isset($_POST["delete_contact_id"])) {
        $delete_contact_id = $_POST["delete_contact_id"];
        $delete_contact_sql = "DELETE FROM contacts WHERE id=".$delete_contact_id;
        $conn->query($delete_contact_sql);
    }
    if(isset($_POST["edit_contact"])) {
        $edit_contact_id = $_POST["edit_contact_id"];
        $name = $_POST["name"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];
        $edit_contact = "UPDATE contacts SET name = '$name', mobile = '$mobile', email = '$email' WHERE id = $edit_contact_id";
        $conn->query($edit_contact);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Contacts</title>
        <link rel="icon" href="https://github.com/fluidicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&family=Noto+Sans+JP:wght@700&display=swap');
            body {
                font-family: 'Noto Sans JP', sans-serif;
                font-weight: 300;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family:  'Noto Sans JP', sans-serif;
                font-weight: 700;
            }
            .table {
                max-width: none;
                table-layout: fixed;
                word-wrap: break-word;
            }
            ::-webkit-scrollbar {
                width: 4px;
            }
            ::-webkit-scrollbar-thumb {
                background: #212529;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: black;
            }
            ::-webkit-scrollbar-track {
                background: #f8f9fa;
            }
        </style>
        <script>
            function deleteContact(id) {
                $.post("",{"delete_contact_id" : id}, function(){location.assign("")});
            }
            function editContact(id,name,mobile,email) {
                $("#editContact :input[name='edit_contact_id']").val(id);
                $("#editContact :input[name='name']").val(name);
                $("#editContact :input[name='mobile']").val(mobile);
                $("#editContact :input[name='email']").val(email);
                $("#editContact").modal("show");
            }
            $(document).ready(function(){
                $("#contactsSearch").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#contactsList tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </head>
    <body>
        <div class="container pt-3">
            <h3 class="text-center bg-dark text-white p-2 rounded">Contacts</h3>
            <button class="btn btn-dark btn-lg" type="button" style="position: fixed; bottom: 5%; right: 5%;" data-bs-toggle="modal" data-bs-target="#newContact"><strong>+</strong></button>
            <div class="modal fade" id="newContact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newContact" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="container-fluid" id="newContactForm" method="POST" action="">
                            <div class="modal-header">
                                <h4>New Contact</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="name" placeholder="Name..." required>
                                        <label>Name *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="mobile" placeholder="Mobile...">
                                        <label>Mobile</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control mb-3" name="email" placeholder="Email...">
                                        <label>Email</label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark" name="new_contact">Save</button>
                                <button type="button" class="btn btn-danger" onclick="this.form.reset()" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editContact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editContact" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="container-fluid" id="editContactForm" method="POST" action="">
                            <div class="modal-header">
                                <h4>Edit Contact</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="name" placeholder="Name..." required>
                                        <label>Name *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="mobile" placeholder="Mobile...">
                                        <label>Mobile</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control mb-3" name="email" placeholder="Email...">
                                        <label>Email</label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="edit_contact_id">
                                <button type="submit" class="btn btn-dark" name="edit_contact">Save</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="pt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Modify</th>
                        </tr>
                    </thead>
                    <div class="form-floating mb-3">
                        <input type="text" id="contactsSearch" class="form-control" placeholder="Search...">
                        <label>Search</label>
                    </div>
                    <?php
                        $list_contacts = "SELECT * FROM contacts";
                        $contacts_list = $conn->query($list_contacts);
                        if ($contacts_list->num_rows > 0) {
                            echo "<tbody id=\"contactsList\">\r\n";
                            while($row = $contacts_list->fetch_assoc()){
                                echo "                        <tr>\r\n                            <td>".$row['name']."</td>\r\n                            <td>".$row['mobile']."</td>\r\n                            <td>".$row['email']."</td>\r\n                            <td>\r\n                                <div class=\"btn-group\" role=\"group\" aria-label=\"Contacts Actions\"><button class=\"btn btn-danger btn-sm\" onclick=\"deleteContact(".$row['id'].")\"><i class=\"bi bi-trash\"></i></button><button class=\"btn btn-primary btn-sm\" onclick=\"editContact(".$row['id'].",'".$row['name']."','".$row['mobile']."','".$row['email']."')\"><i class=\"bi bi-pencil\"></i></button></div>\r\n                            </td>\r\n                        </tr>\r\n";
                            }
                            echo "\r\n                    </tbody>\r\n";
                        } else {
                            echo "<caption>Your contacts list seems to be empty.</caption>\r\n";
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
<?php
    $conn->close();
?>
