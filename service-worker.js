const FILES_TO_CACHE = [ 'offline.html', ];
var CACHE_NAME = 'Cache'; 

self.addEventListener('fetch', function(evt) {
	if (evt.request.mode !== 'navigate') 
{ 
	// Not a page navigation, bail. return; 
} 
evt.respondWith( 
	fetch(evt.request) 
	.catch(() => { 
		return caches.open(CACHE_NAME) 
		.then((cache) => { 
			return cache.match('offline.html'); 
		}); 
	}) 
	); 

});

self.addEventListener('activate', (evt) => {
	evt.waitUntil( 
		caches.keys().then((keyList) => { 
			return Promise.all(keyList.map((key) => { 
				if (key !== CACHE_NAME) { 
					console.log('[ServiceWorker] Removing old cache', key); 
					return caches.delete(key); 
				} 
			}));
		})
		); 

});

self.addEventListener('install', (evt) => {
	evt.waitUntil( 
		caches.open(CACHE_NAME).then((cache) => { 
			console.log('[ServiceWorker] Pre-caching offline page'); 
			return cache.addAll(
				[
					'/offline.html',
					'/jquery-3.4.1.min.js',
					'/jquery-3.4.1.slim.min.js',
					'/bootstrap/js/bootstrap.min.js',
					'/bootstrap/css/bootstrap.min.css'
				]
			);
		}) 
	);
	self.skipWaiting();

});
