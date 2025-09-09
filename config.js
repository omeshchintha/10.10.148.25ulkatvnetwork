// // config.js
// // const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

// // export const MAIN_CDN_URL = isLocal 
// //   ? "http://localhost:3000/"   // Local run chesthe idi
// //   : "http://10.10.148.25/";    // Server lo run chesthe idi
// var SPEEDTEST_SERVERS = [
//   // {
//   //   name: "Client-148.30",
//   //   server: "//10.10.148.30/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   // {
//   //   name: "Client-148.31",
//   //   server: "//10.10.148.31/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   // {
//   //   name: "Client-148.32",
//   //   server: "//10.10.148.32/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   //  {
//   //   name: "Main CDN Server",
//   //   server: "http://10.10.148.25:80/",   // correct format
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   //   {
//   //   name: "Giganet IPTV Mumbai",
//   //   server: "//103.98.7.234/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   //   {
//   //   name: "VijayWada Bsnl",
//   //   server: "//192.168.80.2/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   //  {
//   //   name: "BSNL HYDERABAD",
//   //   server: "//192.168.80.50/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   //   {
//   //   name: "RailTel Kolkata",
//   //   server: "//172.26.147.14/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },
//   //  {
//   //   name: "RailTel Bhubaneswar",
//   //   server: "//172.26.147.46/",
//   //   dlURL: "backend/garbage.php",
//   //   ulURL: "backend/empty.php",
//   //   pingURL: "backend/empty.php",
//   //   getIpURL: "backend/getIP.php"
//   // },

  
//   {
//     name: "Main CDN IP",
//     server: "//10.5.5.150/",   // correct format
//     dlURL: "backend/garbage.php",
//     ulURL: "backend/empty.php",
//     pingURL: "backend/empty.php",
//     getIpURL: "backend/getIP.php"
//   },
//     {
//     name: "CDN DSN3",
//     server: "//10.6.6.165/",
//     dlURL: "backend/garbage.php",
//     ulURL: "backend/empty.php",
//     pingURL: "backend/empty.php",
//     getIpURL: "backend/getIP.php"
//   },
//     {
//     name: "BLCRDHE EDGECDN1006",
//     server: "//10.7.7.252/",
//     dlURL: "backend/garbage.php",
//     ulURL: "backend/empty.php",
//     pingURL: "backend/empty.php",
//     getIpURL: "backend/getIP.php"
//   },
//    {
//     name: "EDGECDN KAMALAMILLSHATHWAY1007",
//     server: "//172.31.42.2/",
//     dlURL: "backend/garbage.php",
//     ulURL: "backend/empty.php",
//     pingURL: "backend/empty.php",
//     getIpURL: "backend/getIP.php"
//   },
//     {
//     name: "HYDERABAD EDGECDN1008",
//     server: "//172.31.32.2/",
//     dlURL: "backend/garbage.php",
//     ulURL: "backend/empty.php",
//     pingURL: "backend/empty.php",
//     getIpURL: "backend/getIP.php"
//   },
//    {
//     name: "KANPUR EXCITEL EDGECDN1010",
//     server: "//172.29.3.178/",
//     dlURL: "backend/garbage.php",
//     ulURL: "backend/empty.php",
//     pingURL: "backend/empty.php",
//     getIpURL: "backend/getIP.php"
//   },
// ];



// config.js
// Uncomment below lines if you want to detect local environment
// const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

// export const MAIN_CDN_URL = isLocal 
//   ? "http://localhost:3000/"   // Local run
//   : "http://10.10.148.25/";    // Server run

var SPEEDTEST_SERVERS = [
  {
    name: "Main CDN IP",
    server: "//192.168.12.103/",
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
    name: "EDGECDN KAMALAMILLSHATHWAY1007",
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
    name: "KANPUR EXCITEL EDGECDN1010",
    server: "//172.29.3.178/",
    dlURL: "backend/garbage.php",
    ulURL: "backend/empty.php",
    pingURL: "backend/empty.php",
    getIpURL: "backend/getIP.php"
  }
];
