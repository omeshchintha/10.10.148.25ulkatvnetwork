// config.js
// const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

// export const MAIN_CDN_URL = isLocal 
//   ? "http://localhost:3000/"   // Local run chesthe idi
//   : "http://10.10.148.25/";    // Server lo run chesthe idi
var SPEEDTEST_SERVERS = [
  {
    name: "Client-148.30",
    server: "//10.10.148.30/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
  {
    name: "Client-148.31",
    server: "//10.10.148.31/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
  {
    name: "Client-148.32",
    server: "//10.10.148.32/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
   {
    name: "Main CDN Server",
    server: "http://10.10.148.25:80/",   // correct format
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
    {
    name: "Giganet IPTV Mumbai",
    server: "//103.98.7.234/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
    {
    name: "VijayWada Bsnl",
    server: "//192.168.80.2/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
   {
    name: "BSNL HYDERABAD",
    server: "//192.168.80.50/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
    {
    name: "RailTel Kolkata",
    server: "//172.26.147.14/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
   {
    name: "RailTel Bhubaneswar",
    server: "//172.26.147.46/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  },
];
