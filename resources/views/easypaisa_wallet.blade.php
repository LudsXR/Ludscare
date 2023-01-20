
<h1>Proccessing Authorization</h2>

<?php if (isset($_GET['auth_token'])) {?>
<form id="confirm" action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf" method="POST" >
    <input name="auth_token" value="<?php echo $_GET['auth_token'] ?>" hidden = "true"/>
    <input name="postBackURL" value="{{url('')}}/easypaisa-after-payment" hidden =
    "true"/>
    {{-- <input value="confirm" type = "submit" name= "pay"/> --}}
</form>
<script>
    document.getElementById("confirm").submit();
    </script>
<?php } else {?>


    <form id='intial' action="https://easypay.easypaisa.com.pk/easypay/Index.jsf" method="POST" >
        <! -- Store Id Provided by Easypay-->
            <input name="storeId" value="<?php echo $storeId; ?>" hidden = "true"/>
            <! -- Amount of Transaction from merchant’s website -->
            <input name="amount" value="<?php echo $amount; ?>" hidden = "true"/>
            <! – Post back URL from merchant’s website -- >
            <input name="postBackURL" value="<?php echo $post_back_url; ?>" hidden = "true"/>
            <! – Order Reference Number from merchant’s website -- >
            <input name="orderRefNum" value="<?php echo  $orderId; ?>" hidden = "true"/>
            <! – Expiry Date from merchant’s website (Optional) -- >
            <input type ="hidden" name="expiryDate" value="<?php echo $expiryDate; ?>">
            <! – Merchant Hash Value (Optional) -- >
            <input type ="hidden" name="merchantHashedReq" value="<?php echo $hashRequest; ?>">
            <! – If Merchant wants to redirect to Merchant website after payment completion (Optional) -- >
            <input type ="hidden" name="autoRedirect" value="1">
            <! – If merchant wants to post specific Payment Method (Optional) -- >
            <input type ="hidden" name="paymentMethod" value="<?php echo $paymentMethodVal; ?>">
            <! – If merchant wants to post specific Payment Method (Optional) -- >

            <! – If merchant wants to post specific Bank Identifier (Optional) -- >
            <input type ="hidden" name="bankIdentifier" value="UBL456">
            <! – This is the button of the form which submits the form -- >
            {{-- <input type = "submit"  value="pay"> --}}
        </form>
        <script>
            document.getElementById("intial").submit();
            </script>

    <?php }


?>


