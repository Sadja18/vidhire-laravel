# blueprint.md — VidHire

Built for Horizon Sphere Equity’s 24-hour challenge.

---

I built this in one day.

Not because I’m fast — but because I had to be.

They asked for a video interview app. So I made one that actually works: Admins create interviews, candidates record answers (via link), reviewers score them. All in a clean, server-rendered Laravel app. No APIs. No mobile apps. No cloud magic.

Just PHP, MySQL, and a droplet.

---

### Tech Stack (The Real Stuff)

- **Laravel 12** — because it’s the best tool for a full-stack web app with Blade.
- **PHP 8.2** — stable, fast, and what I know.
- **MariaDB 10.11** — installed locally on Ubuntu 24.04. Called it “MySQL” everywhere because that’s what they asked for. It works the same.
- **Apache2** — simple, reliable, no Docker headaches.
- **Session auth** — not Sanctum. Why? Because this isn’t an API. It’s a website. You log in, you get redirected. Done.
- **PDF guides** — made with Scribe from my own demo. Embedded in the app. No external links. No extra hosting. Just click and read.

---

### What I Didn’t Do (And Why)

#### ❌ No video uploads
I didn’t build file storage, transcoding, or CDN pipelines.

Why?

Because it would’ve taken days — not hours — to get right in production.  
Instead, candidates paste a link: Cloudinary, YouTube unlisted, Dropbox, whatever.  
It’s not perfect — but it *works*. And I could show it working in under 5 minutes.

#### ❌ No advanced validation
Fields are required. That’s it.

No regex on emails. No sanitization on comments.  
I knew I’d run out of time. So I focused on the core flow:  
Create → Record → Review.  
Everything else can be added later.

#### ❌ No API / Sanctum
This is a web app. Not an SPA. Not a mobile backend.  
Blade templates + session auth = exactly what Laravel was built for.  
Sanctum? Overkill. And it adds complexity I didn’t have time for.

#### ❌ No fancy UI
Bootstrap. Basic buttons. No animations. No custom CSS.  
If it loads and works, it’s good enough.

---

### How It Works (The Routes)

Here’s the actual structure — no fluff:

```
Admin:
  /admin/dashboard
  /admin/interviews/create
  /admin/interviews/{id}/generate-link   → creates a unique token for candidate

Candidate:
  /candidate/interview/{token}           → view interview, enter video URL, submit

Reviewer:
  /reviewer/dashboard
  /reviewer/interview/{id}/candidates    → list all who submitted
  /reviewer/interview/{id}/candidate/{cand}/review → score + comment

Shared:
  /login
  /logout
  /about (my GitHub, portfolio, etc.)
  /guides (role-specific PDFs)
```

All routes are protected by Laravel’s built-in auth.  
No JWT. No tokens in localStorage. Just cookies. Simple.

---

### Deployment

- Hosted on a **DigitalOcean droplet** (paid, Ubuntu 24.04).
- Apache2. No Nginx tweaks. No reverse proxies.
- Database: MariaDB. Installed manually. Migrated via `php artisan migrate`.
- Composer: Ran as root because I had to. Used `--no-dev --optimize-autoloader`.  
  Yes, I saw the warning. I ignored it. This isn’t a shared server. I control everything.  
  The only thing running here is my code. No plugins. No scripts. Just `vendor/`.

I did *not* commit `.env`.  
I *did* set permissions correctly:  
```bash
chown -R www-data:www-data /var/www/vidhire
chmod -R 775 storage bootstrap/cache
```

Live URL: `http://139.59.89.144`

---

### Documentation

I didn’t write a manual.

I recorded myself using the app — with Scribe — then exported each role’s flow as a PDF.  
Put them in `/public/guide-files/`.  
Linked them from the navbar.

So when someone clicks “View Guide” as a reviewer, they see *exactly* what I showed in my Loom video.

No theory. No diagrams. Just what it looks like to use.

---

### Final Thought

This isn’t a masterpiece.

It’s not perfect.

But it’s real.

I built something people can test — right now — without installing anything.  
I didn’t wait for “perfect.” I shipped it.

And if you’re hiring someone who can turn vague requirements into a working product under pressure —  
this is the kind of person you want.

Not the one who spent three weeks on a React frontend.  
The one who got it done.

—

✅ Deployed.  
✅ Documented.  
✅ Sent.

Let me know if you want to see the code.
