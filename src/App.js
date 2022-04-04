import { BrowserRouter, Route, Switch } from 'react-router-dom';
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
    
      <Switch>
        <Route exact path='/' component={Home} />
        <Route path='/SignUp' component={SignUp} />
        <Route path='/RegistrationConfirmation' component={RegistrationConfirmation} />
        <Route path='/SignIn' component={SignIn} />
        <Route path='/ForgotPassword' component={ForgotPassword} />
        <Route path='/NewPassword' component={NewPassword} />
        <Route path='/CompleteProfile' component={CompleteProfile} />
        <Route path='/Main' component={Main} />
        <Route path='/Profile' component={Profile} />
        <Route path='/Notifications' component={Notifications} />
        <Route path='/History' component={History} />
        <Route path='/Favorites' component={Favorites} />
        <Route path='/MemberProfile/:id' component={MemberProfile} />
        <Route component={NotFound} />
      </Switch>
      
      <Footer/>
    </BrowserRouter>
  );
}

export default App;