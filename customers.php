<div class="row">
    <div class="col-lg-4">
        <form action="add_customer.php" method="POST">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="form-group col-md-10">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="0712345678" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" placeholder="johndoe@email.coms" required>
            </div>
            <div class="form-group">
                <label>Street</label>
                <input type="text" class="form-control" name="street">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Postal Code</label>
                    <input type="text" class="form-control" name="postal_code">
                </div>
                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" class="form-control" name="city">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Country Code</label>
                    <input type="text" class="form-control" name="country_code">
                </div>
                <div class="form-group col-md-6">
                    <label>Country</label>
                    <input type="text" class="form-control" name="country">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>
    <div class="col-lg-8">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $connection = DatabaseConnection::connect();
                    $query = $connection->prepare("SELECT * FROM clients ORDER BY id DESC");
                    $query->execute(array());
                    $customers = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($customers as $customer){
                        $query = $connection->prepare("SELECT * FROM apis_customer_link WHERE client_id = ?");
                        $query->execute(array($customer->id));
                        $record = $query->fetch(PDO::FETCH_OBJ); 
                        $badge = '';
                        if($record){
                            $badge = "<span class='badge badge-success badge-pill'>Linked</span>";
                        }   
                ?>
                <tr>
                    <th scope="row">1</th>
                    <td><?=$customer->client_fname?> <?=$badge?></td>
                    <td><?=$customer->client_phone?></td>
                    <td><?=$customer->client_email?></td>
                </tr>
                <?
                    }
                ?>

            </tbody>
        </table>
    </div>
</div>