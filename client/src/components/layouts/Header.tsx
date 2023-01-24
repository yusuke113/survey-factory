import Link from "next/link";
import styles from "../../styles/components/layouts/Header.module.scss";

export const Header = () => {
  return (
    <header className={styles.header}>
      <div className={styles.header_inner}>
        <nav>
          <Link href="/" className={styles.header_nav_button}>アンケートを探す</Link>
          <Link href="/" className={styles.header_nav_button}>アンケートを作る</Link>
          <Link href="/" className={styles.header_nav_button}>ランキング</Link>
        </nav>
        <div className={styles.header_button_wrapper}>
          <Link href="/" className={`${styles.header_nav_button} ${styles.header_nav_button_login}`}>ログイン</Link>
        </div>
      </div>
    </header>
  )
}
