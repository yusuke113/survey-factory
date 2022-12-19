import { Footer } from './layouts/Footer';
import { Header } from './layouts/Header';

export default function Layout({ children }) {
  return (
    <>
      <Header />
      <main>{children}</main>
      <Footer />
    </>
  );
}
