<route-meta>
    {
    "authRequired": true,
    "roles": "editor"
    }
</route-meta>
<script>
    import AbstracForm from "@views/admin/AbstracForm";
    export default {
        name: "PostEdit",
        extends:AbstracForm,
        mounted() {
            this.page = this.$route.params.id
        }
    }
</script>
