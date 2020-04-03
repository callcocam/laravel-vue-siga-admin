import auth from "@/plugins/auth"

import Vue from 'vue'

import * as moment from 'moment';

import 'moment/locale/pt-br';

moment.locale('pt-BR');


window.auth = auth;

import AuthPlugin from "@/plugins/auth"


Vue.use(AuthPlugin);

auth.setAuthenticated()
