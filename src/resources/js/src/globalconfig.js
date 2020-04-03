import auth from "@/plugins/auth"

window.auth = auth;

import axios from "@/plugins/axios"

window.axios = axios;

import * as moment from 'moment';

import 'moment/locale/pt-br';

moment.locale('pt-BR');






auth.setAuthenticated()
