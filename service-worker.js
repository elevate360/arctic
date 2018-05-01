/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("https://storage.googleapis.com/workbox-cdn/releases/3.1.0/workbox-sw.js");

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "404.html",
    "revision": "3b27e7ed3f0bae256ffda321a2e50c76"
  },
  {
    "url": "assets/css/3.styles.6d5c2718.css",
    "revision": "aeca429204c6567a08ab52a0b08de6b3"
  },
  {
    "url": "assets/img/search.83621669.svg",
    "revision": "83621669651b9a3d4bf64d1a670ad856"
  },
  {
    "url": "assets/js/0.0bc1a9b4.js",
    "revision": "4ba54d7301ccd474041463b7f9ac22b8"
  },
  {
    "url": "assets/js/1.929014a5.js",
    "revision": "b27a97bc860ae20489a2ff1430471b2a"
  },
  {
    "url": "assets/js/2.bd2cfacf.js",
    "revision": "9dbe9bd42e8e6db8cb73206897a15fa8"
  },
  {
    "url": "assets/js/app.6eda28db.js",
    "revision": "5866877f98c81d27d30800345d3dc351"
  },
  {
    "url": "config/index.html",
    "revision": "b46c0c30fec50112b87d4a1d512e7515"
  },
  {
    "url": "index.html",
    "revision": "204160d7d68deaebb81ab26473b482d7"
  },
  {
    "url": "logo.png",
    "revision": "148624a82ffce46d282098016c272674"
  },
  {
    "url": "screenshot.jpg",
    "revision": "e6197a12e26bdce42e32b138465e7510"
  },
  {
    "url": "setup/index.html",
    "revision": "6b2a74e5645822bdbba06dfcca73db64"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.suppressWarnings();
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
