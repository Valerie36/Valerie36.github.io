var CACHE_NAME = 'meal-cache-v1';
var CACHE_DYNAMIC_NAME = 'meal-cache-v2';

self.addEventListener('install', function(event) {
	console.log('[Service Worker] Installing Service Worker ...', event);
	event.waitUntil(
		caches.open(CACHE_DYNAMIC_NAME)
		.then(function(cache) {
			console.log('[Service Worker] Precaching App Shell');
			cache.addAll([
				'/',
				'/jquery-3.4.1.min.js',
				'/jquery-3.4.1.slim.min.js',
				'/bootstrap/js/bootstrap.min.js',
				'/bootstrap/css/bootstrap.min.css'
				]);
		})
		)
});

self.addEventListener('activate', (evt) => {
	evt.waitUntil( 
		caches.keys()
		.then((keyList) => { 
			return Promise.all(keyList.map((key) => { 
				if (key !== CACHE_NAME && key !== CACHE_DYNAMIC_NAME) { 
					console.log('[ServiceWorker] Removing old cache', key); 
					return caches.delete(key); 
				} 
			}));
		})
		);
	return self.clients.claim();
});

self.addEventListener('fetch', function(event) {
	event.respondWith(
		caches.match(event.request)
		.then(function(response) {
			if (response) {
				return response;
			} else {
				return fetch(event.request)
				.then(function(res) {
					return caches.open(CACHE_DYNAMIC_NAME)
					.then(function(cache) {
						cache.put(event.request.url, res.clone());
						return res;
					})
				})
				.catch(function(err) {
					return caches.open(CACHE_NAME)
					.then(function(cache) {
						return cache.match('offline.html');
					});
				});
			}
		})
		);
});

