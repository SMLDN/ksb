<script>
export default {
    validate({ params }) {
        const pattern = /^[0-9a-zA-Z]+$/;
        return params.userId && pattern.test(params.userId);
    }
};
</script>>