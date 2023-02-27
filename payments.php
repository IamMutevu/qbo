<div class="row">
    <div class="col-lg-4">
        <form action="add_payment.php" method="POST">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
            <div class="form-group">
                <label>Customer</label>
                <select name="client_id" class="form-control" required>
                    <option value="">Select a customer</option>
                <?php
                    $connection = DatabaseConnection::connect();
                    $query = $connection->prepare("SELECT * FROM clients ORDER BY id DESC");
                    $query->execute(array());
                    $customers = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($customers as $customer){
                ?>
                    <option value="<?=$customer->id?>"><?=$customer->client_fname?> - <?=$customer->client_phone?></option>
                <?
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" name="amount" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="pay_date" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-3">Submit</button>
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
                    $query = $connection->prepare("SELECT payments.*, clients.client_fname FROM payments LEFT JOIN clients ON payments.client_id = clients.id ORDER BY id DESC");
                    $query->execute(array());
                    $payments = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($payments as $payment){
                ?>
                <tr>
                    <th scope="row">1</th>
                    <td><?=$payment->client_fname?></td>
                    <td><?=$payment->amount?></td>
                    <td><?=$payment->pay_date?></td>
                </tr>
                <?
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>