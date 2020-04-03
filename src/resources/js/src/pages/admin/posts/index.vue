<route-meta>
    {
    "authRequired": true,
    "roles": "editor"
    }
</route-meta>
<script>
    // @ is an alias to /src
    import AbstractList from "@views/admin/AbstractList";
    export default {
        name: 'admin',
        extends:AbstractList,
        mounted() {
            this.page = "Posts"
        }
    }
</script>
