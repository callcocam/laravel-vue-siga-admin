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
                  </ul>
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ml-auto">
                      <!-- Authentication Links -->
                       <li class="nav-item">
                           <router-link class="nav-link" :to="{name:'admin.auth.login'}">{{ $t("Login") }}</router-link>
                      </li>
                      <li class="nav-item">
                          <router-link class="nav-link" :to="{name:'admin.auth.register'}">{{ $t("Register") }}</router-link>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
      <main class="py-4">
          <router-view/>
      </main>
  </div>
</template>
