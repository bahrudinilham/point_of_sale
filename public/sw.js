const CACHE_NAME = "konter-pos-v3";
const urlsToCache = ["/offline.html", "/logo.png", "/manifest.json"];

// Install SW
self.addEventListener("install", (event) => {
    // Force new SW to activate immediately
    self.skipWaiting();

    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                console.log("[ServiceWorker] Caching app shell");
                return cache.addAll(urlsToCache);
            })
            .catch((err) => {
                console.error("[ServiceWorker] Caching failed:", err);
            })
    );
});

// Activate SW
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches
            .keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheWhitelist.indexOf(cacheName) === -1) {
                            console.log(
                                "[ServiceWorker] Deleting old cache:",
                                cacheName
                            );
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            .then(() => {
                console.log("[ServiceWorker] Claiming clients");
                return self.clients.claim();
            })
    );
});

// Fetch Strategy
self.addEventListener("fetch", (event) => {
    const url = new URL(event.request.url);

    // Ignore non-http requests (e.g. chrome-extension://)
    if (!url.protocol.startsWith("http")) return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Return validity check
                // We PERMIT response.type !== 'basic' to allow caching CDN resources (fonts, scripts)
                if (!response || response.status !== 200) {
                    return response;
                }

                // Cache successful GET requests (Dynamic Caching)
                if (event.request.method === "GET") {
                    const responseToCache = response.clone();
                    caches
                        .open(CACHE_NAME)
                        .then((cache) => {
                            cache.put(event.request, responseToCache);
                        })
                        .catch((err) => {
                            // Ignore quota exceeded errors or similar
                            // console.warn('Cache put failed:', err);
                        });
                }

                return response;
            })
            .catch(() => {
                // Network failed, try cache
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }

                    // Fallback for navigation (HTML pages) -> Offline Page
                    if (event.request.mode === "navigate") {
                        return caches.match("/offline.html");
                    }

                    return null;
                });
            })
    );
});
