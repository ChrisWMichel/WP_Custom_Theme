/******/ (() => { // webpackBootstrap
/*!*******************************************!*\
  !*** ./src/blocks/auth-modal/frontend.js ***!
  \*******************************************/
document.addEventListener('DOMContentLoaded', () => {
  const authModal = document.querySelector('.wp-block-udemy-plus-auth-modal');
  const openModalButtons = document.querySelectorAll('.open-modal');
  const closeModalButtons = document.querySelectorAll('.modal-overlay, .modal-btn-close');
  openModalButtons.forEach(button => {
    button.addEventListener('click', e => {
      e.preventDefault();
      if (window.ct_auth_rest && window.ct_auth_rest.loggedIn) {
        return;
      }
      authModal.classList.add('modal-show');
    });
  });
  closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
      authModal.classList.remove('modal-show');
    });
  });
  const tabs = authModal.querySelectorAll('.tabs a');
  const signinForm = authModal.querySelector('#signin-tab');
  const signupForm = authModal.querySelector('#signup-tab');
  tabs.forEach(tab => {
    tab.addEventListener('click', e => {
      e.preventDefault();
      tabs.forEach(t => t.classList.remove('active-tab'));
      tab.classList.add('active-tab');
      const activeTab = e.currentTarget.getAttribute('href');
      if (activeTab === '#signin-tab') {
        signinForm.style.display = 'block';
        signupForm.style.display = 'none';
      } else {
        signupForm.style.display = 'block';
        signinForm.style.display = 'none';
      }
    });
  });
  signupForm.addEventListener('submit', async e => {
    e.preventDefault();
    const signupFieldset = signupForm.querySelector('fieldset');
    signupFieldset.setAttribute('disabled', true);
    const signupStatusDiv = signupForm.querySelector('#signup-status');
    signupStatusDiv.innerHTML = `
            <div class="modal-status modal-status-info">
                Processing your registration...
            </div>
        `;
    const formData = {
      username: signupForm.querySelector('#su-name').value,
      email: signupForm.querySelector('#su-email').value,
      password: signupForm.querySelector('#su-password').value
    };
    try {
      const response = await fetch(`${window.ct_auth_rest.signup}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      });
      const responseJSON = await response.json();
      signupFieldset.removeAttribute('disabled');
      signupStatusDiv.innerHTML = '';
      if (responseJSON.status === 2) {
        signupStatusDiv.innerHTML = `
                    <div class="modal-status modal-status-success">
                        ${responseJSON.message}
                    </div>
                `;
        location.reload();
      } else {
        signupFieldset.removeAttribute('disabled');
        signupStatusDiv.innerHTML = `
                    <div class="modal-status modal-status-danger">
                        ${responseJSON.message}
                    </div>
                `;
      }
    } catch (error) {
      signupFieldset.removeAttribute('disabled');
      signupStatusDiv.innerHTML = `
                <div class="modal-status modal-status-danger">
                    An error occurred. Please try again.
                </div>
            `;
      console.error('Error:', error);
    }
  });
  signinForm.addEventListener('submit', async e => {
    e.preventDefault();
    const signinFieldset = signinForm.querySelector('fieldset');
    signinFieldset.setAttribute('disabled', true);
    const signinStatusDiv = signinForm.querySelector('#signin-status');
    signinStatusDiv.innerHTML = `
            <div class="modal-status modal-status-info">
                Signing you in...
            </div>
        `;
    const formData = {
      username: signinForm.querySelector('#si-email').value,
      password: signinForm.querySelector('#si-password').value
    };
    try {
      const response = await fetch(`${window.ct_auth_rest.login}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      });
      const responseJSON = await response.json();
      signinFieldset.removeAttribute('disabled');
      if (responseJSON.status === 2) {
        signinStatusDiv.innerHTML = `
                    <div class="modal-status modal-status-success">
                        ${responseJSON.message}
                    </div>
                `;
        location.reload();
      } else {
        signinStatusDiv.innerHTML = `
                    <div class="modal-status modal-status-danger">
                        ${responseJSON.message}
                    </div>
                `;
      }
    } catch (error) {
      signinFieldset.removeAttribute('disabled');
      signinStatusDiv.innerHTML = `
                <div class="modal-status modal-status-danger">
                    An error occurred. Please try again.
                </div>
            `;
      console.error('Error:', error);
    }
  });
});
/******/ })()
;
//# sourceMappingURL=frontend.js.map