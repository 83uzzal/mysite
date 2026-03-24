        const moviePairs = [
            ["images/exclusive/amazon-t.png", "images/exclusive/netflix-t.png"],
            ["images/exclusive/iphone-t.png", "images/exclusive/finance-guide-t.png"],
            ["images/exclusive/walmart-t.jpg", "images/exclusive/target-t.jpg"]
        ];
        
		function triggerThunderCycle() {
    const body = document.body;
    const leftPoster = document.getElementById('poster-left');
    const rightPoster = document.getElementById('poster-right');
    
    if (window.innerWidth < 1300) return; 

    // ইমেজ সোর্স আপডেট
    leftPoster.querySelector('img').src = moviePairs[pairIndex][0];
    rightPoster.querySelector('img').src = moviePairs[pairIndex][1];

    // ক্লিক করলে লকার দেখানোর ফাংশন সেট করা
    leftPoster.onclick = show_locker;
    rightPoster.onclick = show_locker;

    // বাকি এনিমেশন কোড...
    leftPoster.classList.remove('poster-visible', 'poster-exit');
    rightPoster.classList.remove('poster-visible', 'poster-exit');
    // (আপনার আগের কোডগুলো এখানে থাকবে)
}
		
        let pairIndex = 0;

        function triggerThunderCycle() {
            const body = document.body;
            const leftPoster = document.getElementById('poster-left');
            const rightPoster = document.getElementById('poster-right');
            if (window.innerWidth < 1300) return; 
            leftPoster.querySelector('img').src = moviePairs[pairIndex][0];
            rightPoster.querySelector('img').src = moviePairs[pairIndex][1];
            leftPoster.classList.remove('poster-visible', 'poster-exit');
            rightPoster.classList.remove('poster-visible', 'poster-exit');
            body.classList.add('thunder-flash');
            setTimeout(() => {
                leftPoster.classList.add('poster-visible');
                rightPoster.classList.add('poster-visible');
            }, 200);
            setTimeout(() => body.classList.remove('thunder-flash'), 600);
            setTimeout(() => {
                leftPoster.classList.add('poster-exit');
                rightPoster.classList.add('poster-exit');
            }, 5000);
            setTimeout(() => {
                leftPoster.classList.remove('poster-visible', 'poster-exit');
                rightPoster.classList.remove('poster-visible', 'poster-exit');
                pairIndex = (pairIndex + 1) % moviePairs.length;
            }, 6000);
        }

        setInterval(triggerThunderCycle, 12000);
        setTimeout(triggerThunderCycle, 2000);

        const assets = [
            { name: "AMAZON", value: "$500" },
            { name: "NETFLIX", value: "$500" },
            { name: "WALMART", value: "$500" },
            { name: "TARGET", value: "$500" }
        ];

        let currentIndex = 0;
        const textWrapper = document.getElementById('dynamic-text');
        const assetName = document.getElementById('asset-name');

        function updateText() {
            textWrapper.classList.add('fade-out');
            setTimeout(() => {
                currentIndex = (currentIndex + 1) % assets.length;
                assetName.innerHTML = `${assets[currentIndex].name}<br>${assets[currentIndex].value}`;
                textWrapper.classList.remove('fade-out');
                textWrapper.classList.add('fade-in');
            }, 600);
        }
        setInterval(updateText, 3500);

        function show_locker() {
            document.getElementById('lockerBox').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        window.onclick = function(event) {
            const locker = document.getElementById('lockerBox');
            if (event.target == locker) {
                locker.style.display = "none";
                document.body.style.overflow = 'auto';
            }
        }

        window.addEventListener('load', () => {
            const promo = document.getElementById('promoPopup');
            setTimeout(() => {
                promo.style.display = 'flex';
                document.body.style.overflow = 'hidden'; 
            }, 1000);

            setTimeout(() => {
                closePromo();
            }, 5000);
        });

        function closePromo() {
            const promo = document.getElementById('promoPopup');
            if(promo.style.display === 'none') return; 
            
            promo.style.opacity = '0';
            promo.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                promo.style.display = 'none';
                if(document.getElementById('lockerBox').style.display !== 'flex') {
                    document.body.style.overflow = 'auto';
                }
                showMiniSticky();
                setTimeout(triggerRightSlide, 1000);
            }, 500);
        }

        function triggerRightSlide() {
            const rightPop = document.getElementById('sideSlideRight');
            rightPop.classList.remove('exit');
            rightPop.classList.add('active'); 

            setTimeout(() => {
                rightPop.classList.remove('active');
                rightPop.classList.add('exit');
                setTimeout(triggerLeftSlide, 500);
            }, 5000);
        }

        function triggerLeftSlide() {
            const leftPop = document.getElementById('sideSlideLeft');
            leftPop.classList.remove('exit');
            leftPop.classList.add('active'); 

            setTimeout(() => {
                leftPop.classList.remove('active');
                leftPop.classList.add('exit'); 
            }, 5000);
        }

        function showMiniSticky() {
            document.getElementById('miniLeft').style.display = 'block';
            document.getElementById('miniRight').style.display = 'block';
        }
	
