import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import App from './App';
import axios from 'axios'
import reportWebVitals from './reportWebVitals';



// axios.defaults.baseURL = "http://localhost:8080/matcha/api/";




ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
  document.getElementById('root')
);

reportWebVitals();