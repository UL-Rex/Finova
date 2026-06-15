
    const revealElements = document.querySelectorAll('.reveal');
    const observerOptions = {
      threshold: 0.15,
      rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    revealElements.forEach(el => observer.observe(el));

    document.addEventListener('scroll', () => {
      const nav = document.querySelector('nav');
      if (window.scrollY > 50) {
        nav?.classList.add('scrolled');
      } else {
        nav?.classList.remove('scrolled');
      }
    });

    const statNumbers = document.querySelectorAll('[data-count]');
    const countObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.dataset.counted) {
          const target = parseFloat(entry.target.dataset.count);
          const duration = 2000;
          const start = Date.now();

          const animate = () => {
            const progress = (Date.now() - start) / duration;
            if (progress < 1) {
              const current = target * progress;
              entry.target.textContent = current.toFixed(1);
              requestAnimationFrame(animate);
            } else {
              entry.target.textContent = target;
              entry.target.dataset.counted = 'true';
            }
          };
          animate();
        }
      });
    }, { threshold: 0.5 });

    statNumbers.forEach(el => countObserver.observe(el));
  