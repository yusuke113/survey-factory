import { GetServerSideProps, NextPage } from "next";
import styles from '../styles/Home.module.scss';
import { QuestionnaireUseCase } from '../usecase/questionnaireUseCase';
import { Questionnaire } from "../models/domain/questionnaire";
import { Pager } from "../models/domain/pager";
import Link from "next/link";

type HomePage = {
  questionnaires: Questionnaire[]
  pager: Pager
}

const Home: NextPage<HomePage> = ({ questionnaires, pager}) => {
  console.log(questionnaires);
  
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
                      <p className={styles.detail_text}>
                      {questionnaire.description}
                      </p>
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
}

export default Home;

export const getServerSideProps: GetServerSideProps = async () => {
  const useCase = new QuestionnaireUseCase();
  const {data} = await useCase.getRankingList('vote', 1, 10);

  return {
    props: {
      questionnaires: data.questionnaires,
      pager: data.pager
    }
  }
}
