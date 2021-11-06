import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost/pineapplestorm/",
});

export default api