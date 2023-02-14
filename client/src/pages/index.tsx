import { GetServerSideProps, NextPage } from 'next';
import Link from 'next/link';
import styles from '../styles/Home.module.scss';
import { Questionnaire } from '../domain/models/questionnaire';
import { Pager } from '../domain/models/pager';
import { QuestionnaireUseCase } from '../usecase/questionnaireUseCase';

type HomePage = {
  questionnaires: Questionnaire[];
  pager: Pager;
};

const Home: NextPage<HomePage> = ({ questionnaires }) => {
  return (
    <>
      <div className={styles.main_visual}>
        <h1>main visual</h1>
      </div>
      <section>
        <div className={styles.container}>
          <h1></h1>
          <h2 className={styles.heading_main}>ランキング</h2>
          <div className={styles.ranking}>
            <ul className={styles.ranking_list}>
              {questionnaires.map((questionnaire, key) => (
                <li key={key}>
                  <Link href={`/questionnaires/${questionnaire.id}`}>
                    <div className={styles.thumbnail}>
                      <p>{questionnaire.title}</p>
                    </div>
                    <div className={styles.detail}>
                      <p className={styles.title}>{questionnaire.title}</p>
                      <p className={styles.detail_text}>{questionnaire.description}</p>
                    </div>
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>
    </>
  );
};

export default Home;

export const getServerSideProps: GetServerSideProps = async () => {
  const useCase = new QuestionnaireUseCase();

  // アンケート作成機能動作確認のため一時的に100個と作成順にアンケートを取得
  // const { data } = await useCase.getRankingList('vote', 1, 10);
  const { data } = await useCase.getRankingList('created_at', 1, 100);

  return {
    props: {
      questionnaires: data.questionnaires,
      pager: data.pager,
    },
  };
};
