import axios from "axios"

import interceptors from "../interceptors"

interceptors.response(axios);

interceptors.request(axios);

export default axios
