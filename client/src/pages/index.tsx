import { GetServerSideProps, NextPage } from "next";
import styles from '../styles/Home.module.scss';
import { QuestionnaireUseCase } from '../usecase/questionnaireUseCase';
import { QuestionnaireRankingList } from "../models/domain/questionnaire/types";

type HomePage = {
  questionnaireRankingList: QuestionnaireRankingList;
}

const Home: NextPage<HomePage> = ({ questionnaireRankingList }) => {
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
              {questionnaireRankingList.questionnaires.map((questionnaire, key) => (
                <li key={key}>
                  <a href="#">
                    <div className={styles.thumbnail}>
                      <p>{questionnaire.title}</p>
                    </div>
                    <div className={styles.detail}>
                      <p className={styles.title}>{questionnaire.title}</p>
                      <p className={styles.detail_text}>
                      {questionnaire.description}
                      </p>
                    </div>
                  </a>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>
    </>
  );
}

export default Home;

export const getServerSideProps: GetServerSideProps = async (context) => {
  const useCase = new QuestionnaireUseCase();
  const {data} = await useCase.getRankingList('vote', 1, 10);

  return {
    props: {
      questionnaireRankingList: data
    }
  }
}
