(() => {
  const state = {
    activeTab: 'timeline',
    search: '',
    level: 'all',
    page: 1,
    pageSize: 18,
  };

  const data = window.PORTAL_DATA;

  const content = document.getElementById('content');
  const searchInput = document.getElementById('searchInput');
  const levelSelect = document.getElementById('levelSelect');
  const tabs = document.querySelectorAll('.tab');

  const modal = document.getElementById('detailModal');
  const closeModalButton = document.getElementById('closeModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalDescription = document.getElementById('modalDescription');
  const modalSteps = document.getElementById('modalSteps');

  function normalize(value) {
    return String(value || '').toLocaleLowerCase('tr-TR');
  }

  function levelMatches(itemLevel) {
    if (state.level === 'all') return true;
    return Number(itemLevel) === Number(state.level);
  }

  function matchesSearch(haystack) {
    if (!state.search) return true;
    return normalize(haystack).includes(normalize(state.search));
  }

  function openDetail(title, description, steps) {
    modalTitle.textContent = title;
    modalDescription.textContent = description;
    modalSteps.innerHTML = '';
    steps.forEach((step) => {
      const li = document.createElement('li');
      li.textContent = step;
      modalSteps.appendChild(li);
    });
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
  }

  function closeDetail() {
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
  }

  function renderCards(items, renderer) {
    const visibleItems = items.slice(0, state.page * state.pageSize);
    content.innerHTML = '';
    if (!visibleItems.length) {
      content.innerHTML = '<div class="card">Filtreye uygun içerik bulunamadı.</div>';
      return;
    }
    visibleItems.forEach((item) => {
      const card = renderer(item);
      content.appendChild(card);
    });

    if (visibleItems.length < items.length) {
      const more = document.createElement('div');
      more.className = 'card';
      more.innerHTML = '<strong>Daha fazla içerik için aşağı kaydırın.</strong>';
      content.appendChild(more);
    }

    if (window.MathJax && typeof window.MathJax.typeset === 'function') {
      window.MathJax.typeset();
    }
  }

  function timelineRenderer(item) {
    const card = document.createElement('article');
    card.className = 'card';
    card.innerHTML = `
      <span class="meta">${item.category} · ${item.level}. Sınıf</span>
      <h3 class="clickable-title" data-kind="article" data-title="${item.article}">${item.title}</h3>
      <p>${item.summary}</p>
      <div class="formula" data-kind="formula" data-title="${item.article}">$$${item.formula}$$</div>
      <button class="btn-detail" data-kind="formula" data-title="${item.article}">Formül + Makale Adımları</button>
      <button class="btn-detail" data-kind="article" data-title="${item.article}">Makale Detayını Aç</button>
      <small>Kaynak: ${item.source}</small>
    `;
    card.dataset.formulaSteps = JSON.stringify(item.formula_steps);
    card.dataset.articleDetail = item.article_detail;
    return card;
  }

  function articleRenderer(item) {
    const card = document.createElement('article');
    card.className = 'card';
    card.innerHTML = `
      <span class="meta">${item.level}. Sınıf · Makale</span>
      <h3 class="clickable-title" data-kind="article" data-title="${item.article}">${item.article}</h3>
      <p>${item.article_detail}</p>
      <button class="btn-detail" data-kind="article" data-title="${item.article}">Tam Makaleyi Oku</button>
    `;
    card.dataset.articleSteps = JSON.stringify(item.formula_steps);
    card.dataset.articleDetail = item.article_detail;
    return card;
  }

  function problemRenderer(item) {
    const card = document.createElement('article');
    card.className = 'card';
    card.innerHTML = `
      <span class="meta">${item.level}. Sınıf · Problem</span>
      <h3>${item.title}</h3>
      <p>${item.description}</p>
      <button class="btn-detail" data-kind="problem" data-title="${item.title}" data-description="${item.detail}">Detaylı Problem Açıklaması + Adımlar</button>
    `;
    card.dataset.problemSteps = JSON.stringify(item.steps);
    return card;
  }

  function projectRenderer(item) {
    const card = document.createElement('article');
    card.className = 'card';
    card.innerHTML = `
      <span class="meta">${item.level}. Sınıf · Proje</span>
      <h3>${item.title}</h3>
      <p>${item.description}</p>
      <button class="btn-detail" data-kind="project" data-title="${item.title}" data-description="${item.detail}">Proje Detayını Aç</button>
    `;
    card.dataset.projectSteps = JSON.stringify(item.deliverables);
    return card;
  }

  function scientistRenderer(item) {
    const card = document.createElement('article');
    card.className = 'card';
    card.innerHTML = `
      <span class="meta">${item.era} · ${item.specialty}</span>
      <h3>${item.name}</h3>
      <p>${item.detail}</p>
      <img src="${item.photo}" alt="${item.name}" style="width:100%;border-radius:10px;border:1px solid rgba(255,255,255,.12);">
    `;
    return card;
  }

  function filterTimeline() {
    return data.timeline.filter((x) => levelMatches(x.level) && matchesSearch(`${x.title} ${x.summary} ${x.article} ${x.source}`));
  }
  function filterProblems() {
    return data.problems.filter((x) => levelMatches(x.level) && matchesSearch(`${x.title} ${x.description} ${x.detail}`));
  }
  function filterProjects() {
    return data.projects.filter((x) => levelMatches(x.level) && matchesSearch(`${x.title} ${x.description} ${x.detail}`));
  }

  function render() {
    if (state.activeTab === 'timeline') {
      renderCards(filterTimeline(), timelineRenderer);
      return;
    }
    if (state.activeTab === 'articles') {
      renderCards(filterTimeline(), articleRenderer);
      return;
    }
    if (state.activeTab === 'problems') {
      renderCards(filterProblems(), problemRenderer);
      return;
    }
    if (state.activeTab === 'projects') {
      renderCards(filterProjects(), projectRenderer);
      return;
    }
    renderCards(data.scientists.filter((x) => matchesSearch(`${x.name} ${x.detail} ${x.specialty}`)), scientistRenderer);
  }

  function resetAndRender() {
    state.page = 1;
    render();
  }

  searchInput.addEventListener('input', (event) => {
    state.search = event.target.value;
    resetAndRender();
  });

  levelSelect.addEventListener('change', (event) => {
    state.level = event.target.value;
    resetAndRender();
  });

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      tabs.forEach((x) => x.classList.remove('active'));
      tab.classList.add('active');
      state.activeTab = tab.dataset.tab;
      resetAndRender();
    });
  });

  window.addEventListener('scroll', () => {
    const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 220;
    if (!nearBottom) return;
    state.page += 1;
    render();
  });

  content.addEventListener('click', (event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement)) return;
    if (!target.classList.contains('btn-detail') && !target.classList.contains('formula') && !target.classList.contains('clickable-title')) return;

    const card = target.closest('.card');
    if (!card) return;

    const kind = target.dataset.kind;
    const title = target.dataset.title || 'Detay';
    let description = card.dataset.articleDetail || '';

    let steps = [];
    if (kind === 'formula' || kind === 'article') {
      steps = JSON.parse(card.dataset.formulaSteps || card.dataset.articleSteps || '[]');
    } else if (kind === 'problem') {
      description = target.dataset.description || '';
      steps = JSON.parse(card.dataset.problemSteps || '[]');
    } else if (kind === 'project') {
      description = target.dataset.description || '';
      steps = JSON.parse(card.dataset.projectSteps || '[]');
    }

    openDetail(title, description, steps);
  });

  closeModalButton.addEventListener('click', closeDetail);
  modal.addEventListener('click', (event) => {
    if (event.target === modal) closeDetail();
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeDetail();
  });

  render();
})();
