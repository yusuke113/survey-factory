import styles from '../../styles/components/layouts/Footer.module.scss';

export const Footer = () => {
  return (
    <footer className={styles.footer}>
      <div className={styles.footer_inner}>
        <nav>
          <a href="#" className={styles.footer_nav_button}>利用規約</a>
          <a href="#" className={styles.footer_nav_button}>ガイドライン</a>
          <a href="#" className={styles.footer_nav_button}>お問い合わせ</a>
          <a href="#" className={styles.footer_nav_button}>プライバシーポリシー</a>
        </nav>
        <small>example.com Copyright ©2018 All rights reserved.</small>
      </div>
    </footer>
  )

}