<div class="row">
    <div class="col-lg-4">
        <form action="add_customer.php" method="POST">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
            <div class="form-group">
                <label>Customer</label>
                <select name="customer_id" class="form-control">
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" name="amount" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date" required>
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>