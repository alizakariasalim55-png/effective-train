// Menu burger
const burger = document.getElementById('burger');
const menu = document.getElementById('menu');

burger.addEventListener('click', () => menu.classList.toggle('ouvert'));
menu.querySelectorAll('a').forEach(lien =>
  lien.addEventListener('click', () => menu.classList.remove('ouvert'))
);

// Envoi du formulaire sans recharger la page
const form = document.getElementById('formContact');
const retour = document.getElementById('retour');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  retour.textContent = 'Envoi en cours...';
  retour.style.color = '#333';

  try {
    const reponse = await fetch('traitement.php', {
      method: 'POST',
      body: new FormData(form)
    });
    const data = await reponse.json();

    retour.textContent = data.message;
    retour.style.color = data.succes ? 'green' : 'red';
    if (data.succes) form.reset();
  } catch (erreur) {
    retour.textContent = 'Erreur de connexion au serveur.';
    retour.style.color = 'red';
  }
});