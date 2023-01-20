<template>
    <div>
        <appointment-payment-section :route="route"></appointment-payment-section>
       <customer-reviews-section></customer-reviews-section>
    </div>
</template>

<script>
export default {
    props: ["url","route"],
};
</script>
