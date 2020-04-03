<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Laravel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" :aria-label="$t('Toggle navigation')">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">{{ $t("Home") }}</a>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{name:'admin'}">{{ $t("Dashboard") }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{name:'admin.users.index'}">{{ $t("Users") }}</router-link>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" v-if="userData">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                {{ userData.name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <router-link class="nav-link" :to="{name:'admin.auth.profile'}">{{ $t("Profile") }}</router-link>
                                <router-link class="nav-link" :to="{name:'admin.auth.logout'}">{{ $t("Logout") }}</router-link>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            {{userData}}
            <router-view/>
        </main>
    </div>
</template>

<script>
    export default {
        name: "default",
        data () {
            return {
            }
        },
        computed:{

            userData(){
                return this.$store.getters.userInfo
            }
        }
    }
</script>

