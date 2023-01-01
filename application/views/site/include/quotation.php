<div class="user-quotation">
    <!-- <h4 style="margin-bottom: 8px; font-size: 18px; margin-top: 0;"><strong><?= $this->config->item('PROJECT'); ?></strong></h4> -->
    <p style="margin-top: 0; margin-bottom:5px; font-size: 15px;">
        <?= $this->config->item('ADDRESS'); ?>
    </p>
    <p style="margin-top: 0; margin-bottom:5px; font-size: 15px;">
        Name of Customer: <b><?= $quotationDetails['user_name']; ?></b>
    </p>
    <p style="margin-top: 0; margin-bottom:5px; font-size: 15px;">Phone: <b><?= $quotationDetails['phone']; ?></b></p>
    <?php
    if ($isAdmin) {
    ?>
        <p style="margin-top: 0; margin-bottom:5px; font-size: 15px;"><b><a href="https://wa.me/+91<?= $quotationDetails['phone']; ?>">WhatsApp</a></b></p>
    <?php
    }
    ?>

    <p style="margin-top: 0; margin-bottom:5px; font-size: 15px;">
        Email:
        <b><?= $quotationDetails['email']; ?> </b>
    </p>

    <p style="margin-top: 0; margin-bottom:5px; font-size: 15px;">
        Message:
        <b><?= $quotationDetails['message']; ?> </b>
    </p>

    <table style="margin-top: 25px; border:1px solid #ddd; width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 10px 10px; border:1px solid #ddd; text-align: left;">S.No.</th>
                <th style="padding: 10px 10px; border:1px solid #ddd; text-align: left;">Product</th>
                <th style="padding: 10px 10px; border:1px solid #ddd; text-align: left;">Category</th>
                <th style="padding: 10px 10px; border:1px solid #ddd; text-align: left;">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cartProducts as $serialNumber => $cartProduct) {
                $productImage = ($cartProduct['product_image'] && file_exists($cartProduct['product_image'])) ? $cartProduct['product_image'] : 'assets/site/img/img5.png';
            ?>
                <tr>
                    <td style="padding: 5px 10px; border:1px solid #ddd;"><?= $serialNumber + 1; ?></td>
                    <td style="padding: 5px 10px; border:1px solid #ddd;">
                        <img style="vertical-align: middle;" src="<?= site_url($productImage); ?>" alt="<?= $cartProduct['product_title']; ?>" width="70px">
                        <?= $cartProduct['product_title']; ?>

                    </td>
                    <td style="padding: 5px 10px; border:1px solid #ddd;"><?= $cartProduct['category_name']; ?></td>
                    <td style="padding: 5px 10px; border:1px solid #ddd;"><?= $cartProduct['product_price']; ?> INR</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="padding: 15px 10px; border:1px solid #ddd; text-align: right;">Total <?= count($cartProducts); ?> products.</td>
            </tr>
        </tfoot>
    </table>
</div>