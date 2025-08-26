// config.js
// const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

// export const MAIN_CDN_URL = isLocal 
//   ? "http://localhost:3000/"   // Local run chesthe idi
//   : "http://10.10.148.25/";    // Server lo run chesthe idi
var SPEEDTEST_SERVERS = [
  {
    name: "Custom Server",
    server: "http://10.10.148.25/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  }
];
