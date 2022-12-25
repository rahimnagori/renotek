<div class="user-quotation">
    <div class="row"><strong><?= $this->config->item('PROJECT'); ?></strong></div>
    <div class="row"><small><?= $this->config->item('ADDRESS'); ?></small></div>
    <div class="row">
        <div class="col-sm-6">Name of Customer:</div>
        <div class="col-sm-6"><?= $quotationDetails['user_name']; ?></div>
    </div>
    <div class="row">
        <div class="col-sm-6">Phone:</div>
        <div class="col-sm-6"><?= $quotationDetails['phone']; ?></div>
    </div>
    <div class="row">
        <div class="col-sm-6">Email:</div>
        <div class="col-sm-6"><?= $quotationDetails['email']; ?></div>
    </div>
    <table>
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Product</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cartProducts as $serialNumber => $cartProduct) {
                $productImage = ($cartProduct['product_image'] && file_exists($cartProduct['product_image'])) ? $cartProduct['product_image'] : 'assets/site/img/img5.png';
            ?>
                <tr>
                    <td><?= $serialNumber + 1; ?></td>
                    <td>
                        <?= $cartProduct['product_title']; ?>
                        <img src="<?= site_url($productImage); ?>" alt="<?= $cartProduct['product_title']; ?>" width="100">
                    </td>
                    <td><?= $cartProduct['category_name']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total <?= count($cartProducts); ?> products.</td>
            </tr>
        </tfoot>
    </table>
</div>