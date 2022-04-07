import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import Home from './components/Home/Home';
import SignIn from './components/SignIn/SignIn';
import SignUp from './components/SignUp/SignUp';
import ForgotPassword from './components/ForgotPassword/ForgotPassword';
import NewPassword from './components/NewPassword/NewPassword';
import CompleteProfile from './components/CompleteProfile/CompleteProfile';
import Main from './components/Main/Main';
import Notifications from './components/Notifications/Notifications';
import History from './components/History/History';
import Favorites from './components/Favorites/Favorites';
import Profile from './components/Profile/Profile';
import MemberProfile from './components/MemberProfile/MemberProfile';
import RegistrationConfirmation from './components/RegistrationConfirmation/RegistrationConfirmation';
import NotFound from './components/NotFound/NotFound';
import Footer from './components/Footer/Footer';
import './App.css';



function App() {

  return (
    <BrowserRouter>
    
      <Routes>
        <Route path='/' element={<Home/>} />
        <Route path='/SignUp' element={<SignUp/>} />
        <Route path='/RegistrationConfirmation/:username/:token' element={<RegistrationConfirmation/>} />
        <Route path='/SignIn' element={<SignIn/>} />
        <Route path='/ForgotPassword' element={<ForgotPassword/>} />
        <Route path='/NewPassword/:userID/:token' element={<NewPassword/>} />
        <Route path='/CompleteProfile' element={<CompleteProfile/>} />
        <Route path='/Main' element={<Main/>} />
        <Route path='/Profile' element={<Profile/>} />
        <Route path='/Notifications' element={<Notifications/>} />
        <Route path='/History' element={<History/>} />
        <Route path='/Favorites' element={<Favorites/>} />
        <Route path='/MemberProfile/:userID' element={<MemberProfile/>} />
        <Route path='/NotFound' element={<NotFound/>} />
        <Route path='*' element={<Navigate replace to='/NotFound'/>} />
      </Routes>
      
      <Footer/>
    </BrowserRouter>
  );
}

export default App;