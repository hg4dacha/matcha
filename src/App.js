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
        <Route path='/signup' element={<SignUp/>} />
        <Route path='/confirm-registration/:username/:token' element={<RegistrationConfirmation/>} />
        <Route path='/signin' element={<SignIn/>} />
        <Route path='/forgot-password' element={<ForgotPassword/>} />
        <Route path='/new-password/:userid/:token' element={<NewPassword/>} />
        <Route path='/complete-profile' element={<CompleteProfile/>} />
        <Route path='/users' element={<Main/>} />
        <Route path='/users/:userid' element={<MemberProfile/>} />
        <Route path='/profile' element={<Profile/>} />
        <Route path='/notifications' element={<Notifications/>} />
        <Route path='/favorites' element={<Favorites/>} />
        <Route path='/history' element={<History/>} />
        <Route path='/notfound' element={<NotFound/>} />
        <Route path='*' element={<Navigate replace to='/NotFound'/>} />
      </Routes>
      
      <Footer/>
    </BrowserRouter>
  );
}

export default App;