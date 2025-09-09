// config.js
// const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

// export const MAIN_CDN_URL = isLocal 
//   ? "http://localhost:3000/"   // Local run chesthe idi
//   : "http://10.10.148.25/";    // Server lo run chesthe idi
var SPEEDTEST_SERVERS = [
  {
    name: "Client-148.30",
    server: "//103.189.178.121/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
     {
    name: "CDN DSN3",
    server: "//10.6.6.165/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
    {
    name: "BLCRDHE EDGECDN1006",
    server: "//10.7.7.252/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
   {
    name: "KAMALAMILLSHATHWAY1007",
    server: "//172.31.42.2/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
    {
    name: "HYDERABAD EDGECDN1008",
    server: "//172.31.32.2/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
   {
    name: "KANPUR EXCITEL",
    server: "//172.29.3.178/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
      {
    name: "Testing",
    server: "//192.168.12.53/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
];
