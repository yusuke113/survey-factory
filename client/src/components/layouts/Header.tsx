import styles from "../../styles/components/layouts/Header.module.scss";

export const Header = () => {
  return (
    <header className={styles.header}>
      <div className={styles.header_inner}>
        <nav>
          <a href="#" className={styles.header_nav_button}>アンケートを探す</a>
          <a href="#" className={styles.header_nav_button}>アンケートを作る</a>
          <a href="#" className={styles.header_nav_button}>ランキング</a>
        </nav>
        <div className={styles.header_button_wrapper}>
          <a href="#" className={styles.header_nav_button}>ログイン</a>
        </div>
      </div>
    </header>
  )
}
