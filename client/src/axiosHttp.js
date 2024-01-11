import axios from "axios";

const axiosInstance = axios.create({
    baseURL: 'http://localhost:8081/server/api/',
    // headers: {
    //     common: {
    //       'key': '49aed241914cb37562cc025d7e2d3e4c', // Add your default Authorization header here
    //       // Add any other global headers here
    //     },
    //   },
});

export default axiosInstance;