const CACHE_NAME = "konter-pos-v1";
const urlsToCache = ["/", "/dashboard", "/pos", "/offline.html"];

// Install SW and cache static assets
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log("Opened cache");
            return cache.addAll(urlsToCache);
        })
    );
});

// Activate SW and clean old caches
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Network First, fallback to Cache strategy
self.addEventListener("fetch", (event) => {
    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Check if we received a valid response
                if (
                    !response ||
                    response.status !== 200 ||
                    response.type !== "basic"
                ) {
                    return response;
                }

                // Clone the response to cache it
                const responseToCache = response.clone();

                caches.open(CACHE_NAME).then((cache) => {
                    // Only cache GET requests (don't cache POST/PUT API calls)
                    if (event.request.method === "GET") {
                        cache.put(event.request, responseToCache);
                    }
                });

                return response;
            })
            .catch(() => {
                // If offline, try to return from cache
                return caches.match(event.request);
            })
    );
});
