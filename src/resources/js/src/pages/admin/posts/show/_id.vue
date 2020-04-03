<route-meta>
    {
    "authRequired": true,
    "roles": "editor"
    }
</route-meta>
<script>
    import AbstracShow from "@views/admin/AbstracShow";
    export default {
        name: "PostShow",
        extends:AbstracShow,
        mounted() {
            this.page = this.$route.params.id
        }
    }
</script>
